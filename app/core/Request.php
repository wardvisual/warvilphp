<?php


namespace app\core;

class Request
{
    private static array $params = [];
    private static array $query = [];
    private static array $body = [];

    public static function capture()
    {
        self::$query = $_GET;
        self::$body = $_POST;

        // if (self::isMethod('PUT') || self::isMethod('DELETE')) {
        //     // Handle PUT and DELETE requests
        //     parse_str(file_get_contents('php://input'), $put_delete_data);

        //     // Check if it's a JSON request
        //     if (self::isJsonRequest()) {
        //         $json_data = json_decode(file_get_contents('php://input'), true);
        //         self::$body = array_merge(self::$body, $json_data ? $json_data : []);
        //     } else {
        //         // Merge PUT or DELETE data into body
        //         self::$body = array_merge(self::$body, $put_delete_data);
        //     }
        // }

        // if (self::isJsonRequest()) {
        //     // Handle JSON requests
        //     $json_data = json_decode(file_get_contents('php://input'), true);
        //     self::$body = array_merge(self::$body, $json_data ? $json_data : []);
        // }

        // // Handle file uploads
        // if (self::isMethod('PUT') && self::hasFile('file')) {
        //     $file_data = $_FILES['file'];
        //     self::$body['file'] = $file_data;
        // }

        if (self::isMethod('PUT') || self::isMethod('DELETE')) {
            parse_str(file_get_contents('php://input'), $put_delete_data);
            self::$body = array_merge(self::$body, $put_delete_data);
        }

        if (self::isJsonRequest()) {
            $jsonData = json_decode(file_get_contents('php://input'), true);
            self::$body = array_merge(self::$body, $jsonData ? $jsonData : []);
        }
    }

    public static function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function isMethod($method): bool
    {
        return self::method() === strtoupper($method);
    }


    public static function isJsonRequest(): bool
    {
        return isset($_SERVER["CONTENT_TYPE"]) && strpos($_SERVER["CONTENT_TYPE"], 'application/json') !== false;
    }

    public static function all(): array
    {
        return array_merge(self::$query, self::$body, self::$params);
    }

    public static function hasFile($item): bool
    {
        return isset($_FILES[$item]);
    }
    public static function file($item)
    {
        return $_FILES[$item];
    }

    public static function input($item)
    {
        return self::$body[$item] ?? null;
    }

    public static function getBody(): array
    {
        return self::$body;
    }

    public static function add($key, $value)
    {
        self::$body[$key] = $value;
    }

    public static function replace($key, $value)
    {
        if (array_key_exists($key, self::$body)) {
            self::$body[$key] = $value;
        }
    }
    public static function exists($key)
    {
        return array_key_exists($key, self::$body);
    }

    public static function params($key = null)
    {
        if ($key === null) {
            return self::$params;
        }

        return self::$params[$key] ?? null;
    }

    public static function query($keys = null, $defaults = null)
    {
        if ($keys === null) {
            return self::$query;
        }

        if (!is_array($keys)) {
            $keys = [$keys => $defaults];
        }

        $result = [];
        foreach ($keys as $key => $default) {
            if (!isset(self::$query[$key]) && $default !== null) {
                self::$query[$key] = $default;
            }

            $result[$key] = self::$query[$key] ?? null;
        }

        return $result;
    }

    public static function only($items): array
    {
        $inputs = self::all();
        return array_intersect_key($inputs, array_flip((array) $items));
    }

    public static function except($items): array

    {
        $inputs = self::all();
        return array_diff_key($inputs, array_flip((array) $items));
    }

    public static function setParams($matches): void
    {
        $matches = array_intersect_key($matches, array_flip(array_filter(array_keys($matches), 'is_string')));
        self::$params = $matches;
    }

    public static function validate($rules)
    {
        $validatedData = [];
        $errors = [];
        $existingModel = null;

        foreach ($rules as $field => $rule) {
            $value = self::input($field);
            $validatedData[$field] = $value;

            // Split the rules by '|'
            $ruleParts = explode('|', $rule);

            foreach ($ruleParts as $rulePart) {
                // Check if the rule has parameters, e.g. 'max:255'
                if (strpos($rulePart, ':') !== false) {
                    list($ruleName, $ruleParameter) = explode(':', $rulePart);

                    if ($ruleName === 'max' && strlen($value) > $ruleParameter) {
                        $errors[$field][] = 'The ' . $field . ' may not be greater than ' . $ruleParameter . ' characters.';
                    }

                    if ($ruleName === 'min' && strlen($value) < $ruleParameter) {
                        $errors[$field][] = 'The ' . $field . ' must be at least ' . $ruleParameter . ' characters.';
                    }

                    if ($ruleName === 'pattern' && !preg_match($ruleParameter, $value)) {
                        $errors[$field][] = 'The ' . $field . ' format is invalid.';
                    }

                    if ($ruleName === 'unique') {
                        $model = new Model();
                        $model->table($ruleParameter);
                        $existing = $model->find($field, $value);


                        if ($existing->single()) {
                            $errors[$field][] = 'The ' . $field . ' already exists in ' . $ruleParameter;
                        }
                    }

                    if ($ruleName === 'exists') {
                        $model = new Model();
                        $model->table($ruleParameter);
                        $existing = $model->find($field, $value);

                        $existingModel = $existing->single();

                        if (!$existing->single()) {
                            $errors[$field][] = 'The ' . $field . ' does not exist in ' . $ruleParameter;
                        }
                    }

                    if ($ruleName === 'verify') {
                        $result = \app\core\utils\Password::verify($value, $existingModel['password']);

                        if (!$result) {
                            $errors[$field][] = 'The password is incorrect.';
                        }
                    }


                    if ($ruleName === 'confirmed') {
                        $confirmValue = self::input($ruleParameter);
                        if ($value !== $confirmValue) {
                            $errors[$field][] = 'The ' . $field . ' does not match the ' . $ruleParameter . '.';
                        }
                    }

                    if ($ruleName === 'in') {
                        $allowedValues = explode(',', $ruleParameter);
                        if (!in_array($value, $allowedValues)) {
                            $errors[$field][] = 'The ' . $field . ' must be one of the following: ' . $ruleParameter;
                        }
                    }
                } else {
                    if ($rulePart === 'required' && empty($value)) {
                        $errors[$field][] = 'The ' . $field . ' field is required.';
                    }

                    if ($rulePart === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $errors[$field][] = 'The ' . $field . ' must be a valid email address.';
                    }

                    if ($rulePart === 'digits' && !ctype_digit($value)) {
                        $errors[$field][] = 'The ' . $field . ' must be a number.';
                    }

                    if ($rulePart === 'alpha' && !ctype_alpha(str_replace(' ', '', $value))) {
                        $errors[$field][] = 'The ' . $field . ' may only contain letters.';
                    }
                }
            }
        }

        // if there's any error in specific field, add the validation/error from session
        foreach ($errors as $field => $messages) {
            foreach ($messages as $message) {
                addValidationError($field, $message);
            }
        }

        // if there's no error in specific field, remove the validation/error from session
        foreach ($validatedData as $field => $value) {
            if (empty($errors[$field])) {
                removeValidationError($field);
            } else {

                // if there's an error again, put the error message back into the session
                foreach ($errors[$field] as $message) {
                    addValidationError($field, $message);
                }
            }
        }


        if (!empty($errors)) {
            throw new \Exception(json_encode($errors));
        }

        return $validatedData;
    }
}

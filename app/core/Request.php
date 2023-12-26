<?php

namespace app\core;

class Request
{
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function isPostMethod(): bool
    {
        return self::method() === 'POST';
    }

    public static function isGetMethod(): bool
    {
        return self::method() === 'GET';
    }

    public static function exists($type = 'POST')
    {
        $requestData = ($type === 'POST') ? $_POST : $_GET;
        return !empty($requestData);
    }

    public static function input($item)
    {
        $inputs = array_merge($_POST, $_GET, $_FILES);

        // Check if the content type is JSON
        if (strpos($_SERVER["CONTENT_TYPE"], 'application/json') !== false) {
            $jsonData = json_decode(file_get_contents('php://input'), true);
            $inputs = array_merge($inputs, $jsonData ? $jsonData : []);
        }

        return $inputs[$item] ?? '';
    }

    public static function body()
    {
        $body = file_get_contents('php://input');
        $body = json_decode($body, true);
        return $body;
    }


    public static function validate($rules)
    {
        $validatedData = [];
        $errors = [];

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

        if (!empty($errors)) {
            throw new \Exception(json_encode($errors));
        }

        return $validatedData;
    }
}

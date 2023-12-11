<?php

namespace app\core\utils;

use app\core\utils\Hash;

use app\core\Config;
use app\core\Session;

class Token
{
    public static function generate()
    {
        return Session::put(Config::get('session/token_name'), Hash::make(uniqid()));
    }

    public static function check($token)
    {
        $tokenName = Config::get('session/token_name');

        if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
            return true;
        }

        return false;
    }
    public static function generateWithExpiration($expiryInSeconds = 3600) // 3600seconds = 1hr
    {
        $token = bin2hex(random_bytes(16)); // Generate a random token
        $expiration = time() + $expiryInSeconds; // Calculate the expiration timestamp

        $tokenData = [
            'token' => $token,
            'expiration' => $expiration,
        ];

        return base64_encode(json_encode($tokenData));
    }

    public static function verify($token)
    {
        $decodedToken = json_decode(base64_decode($token), true);

        if ($decodedToken && isset($decodedToken['token']) && isset($decodedToken['expiration'])) {
            $currentTimestamp = time();

            if ($currentTimestamp <= $decodedToken['expiration']) {
                return $decodedToken['token'];
            }
        }

        return null;
    }

    public static function generateUniqueNumber($start = '')
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $maxLength = 5;

        $number = $start;

        for ($i = 0; $i < $maxLength; $i++) {
            $randomChar = $characters[rand(0, strlen($characters) - 1)];
            $number .= $randomChar;
        }

        $timestamp = sprintf('%010d', time());

        $number .= $timestamp;

        return $number;
    }
}

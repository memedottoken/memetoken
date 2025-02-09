<?php

namespace App\Services;

class UrlCrypt
{

    private static $method = 'AES-128-ECB'; // Note: ECB is used here for compactness, see security note below


    public static function encrypt(string $data): string
    {
        $encrypted = openssl_encrypt(
            $data,
            static::$method,
            config('app.key'),
            OPENSSL_RAW_DATA
        );

        // Convert to URL-safe base64
        return static::base64UrlEncode($encrypted);
    }

    public static function decrypt(string $data): string
    {
        // Convert from URL-safe base64
        $decoded = static::base64UrlDecode($data);
        return openssl_decrypt(
            $decoded,
            static::$method,
            config('app.key'),
            OPENSSL_RAW_DATA
        );
    }

    private static function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64UrlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }
}

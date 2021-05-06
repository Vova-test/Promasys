<?php

namespace App\Services;

use Illuminate\Encryption\Encrypter;
use Str;

class EncryptService
{
    protected static $encryptionKey;
    protected static $cipher;

	public static function getEncryptionKey()
    {
        $encryptionKey = env("ENCRYPTION_KEY");
        if (Str::startsWith($encryptionKey, 'base64:')) {
            $encryptionKey = substr($encryptionKey, 7);
            $encryptionKey = base64_decode($encryptionKey);
        }

        return $encryptionKey;
    }

    public static function encryptPassword($password)
    {
        static::$encryptionKey = static::getEncryptionKey();
        static::$cipher = config('app.cipher');

        $encrypter = new Encrypter(static::$encryptionKey, static::$cipher);

        return $encrypter->encrypt($password);
    }
}

<?php

namespace App\Services;

use Illuminate\Encryption\Encrypter;
use Str;

class EncryptService
{

	public static function getEncryptionKey()
    {
        $encryptionKey = env("ENCRYPTION_KEY");

        if (Str::startsWith($encryptionKey, 'base64:')) {
            $encryptionKey = substr($encryptionKey, 7);
            $encryptionKey = base64_decode($encryptionKey);
        }

        return $encryptionKey;
    }

    public static function getEncrypter($encryptionKey = false)
    {
        if (!$encryptionKey) {
            $encryptionKey = static::getEncryptionKey();
            $cipher = config('app.cipher');
        } else {
            $cipher = config('app.shortCipher');
        }

        $encrypter = new Encrypter($encryptionKey, $cipher);

        return $encrypter;
    }

    public static function encryptPassword($password)
    {
        $encrypter = static::getEncrypter();

        return $encrypter->encrypt($password);
    }

    public static function decryptPassword($password)
    {
        $encrypter = static::getEncrypter();

        return $encrypter->decrypt($password);
    }

    public static function encryptValue($password, $value)
    {
        $encryptionKey = static::decryptPassword($password);
        $encrypter = static::getEncrypter($encryptionKey);

        return $encrypter->encrypt($value);
    }

    public static function decryptValue($password, $value)
    {
        $encryptionKey = static::decryptPassword($password);
        $encrypter = static::getEncrypter($encryptionKey);

        return $encrypter->decrypt($value);
    }
}

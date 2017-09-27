<?php

namespace Instantor\Report;

use Defuse\Crypto\Exception as Ex;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Core;

class Decrypt
{
	const ENCRYPTION = 'B64/MD5/AES/CBC/PKCS5';

    protected static function hash($salt, $payload)
    {
        ksort($payload);
        $payload_string = $salt;

        foreach ($payload as $val)
        {
            $payload_string .= $val;
        }

        return sha1($payload_string);
    }

    protected static function plainDecrypt($ciphertext, $key, $iv, $cipherMethod)
    {
        Core::ensureConstantExists('OPENSSL_RAW_DATA');
        Core::ensureFunctionExists('openssl_decrypt');

        /** @var string $plaintext */
        $plaintext = \openssl_decrypt(
            $ciphertext,
            $cipherMethod,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        if (!\is_string($plaintext)) 
        {
            throw new Ex\EnvironmentIsBrokenException(
                'openssl_decrypt() failed.'
            );
        }

        return $plaintext;
    }

    protected static function decrypt($key, $payload, $msg_id)
    {
        $key = md5($key, true);
        $iv = md5($msg_id, true);

        $payload = base64_decode($payload);

        $decrypted = self::plainDecrypt($payload, $key, $iv, Core::LEGACY_CIPHER_METHOD);

        return $decrypted;
    }

    protected static function parsePostFields()
    {
        $fields = array(
            'source' => null,
            'msg_id' => null,
            'action' => null,
            'encryption' => null,
            'payload' => null,
            'timestamp' => null,
            'hash' => null
        );

        foreach ($fields as $field => &$value)
        {
            if (isset($_POST[$field]))
            {
                $value = $_POST[$field];
            }

            unset($value);
        }

        return $fields;
    }

	public static function receivePostRequest($source, $api_key, &$payload) 
	{
        $fields = self::parsePostFields();

        $missing_fields = array();

        foreach ($fields as $k => $v)
        {
            if ($v === null)
            {
                $missing_fields[] = $k;
            }
        }

        if (count($missing_fields) !== 0)
        {
            return 'Error: Missing POST field(s): ' . implode(', ', $missing_fields);
        }

        if ($fields['source'] !== $source)
        {
            return 'Error: Invalid Product ID: ' . $fields['source'];
        }

        if ($fields['encryption'] !== self::ENCRYPTION)
        {
            return 'Error: Invalid encryption: ' . $fields['encryption'];
        }

        $hash = $fields['hash'];
        unset($fields['hash']);

        $calc = self::hash($api_key, $fields);

        if ($calc !== $hash)
        {
            return 'Error: Invalid checksum: ' . $hash;
        }

        $payload = self::decrypt($api_key, $fields['payload'], $fields['msg_id']);

        return 'OK: ' . $fields['msg_id'];
    }
}
<?php

namespace AppBundle\Service;

class TokenGenerator
{
    /**
     * Get random token
     *
     * @param int $length Token string length
     *
     * @return string|null
     */
    public function getToken($length = 32)
    {
        $token = null;
        $bytes = ceil($length / 2);

        if (function_exists('openssl_random_pseudo_bytes')) {
            $token = bin2hex(openssl_random_pseudo_bytes($bytes));
        } elseif (extension_loaded('mcrypt_create_iv')) {
            $token = bin2hex(mcrypt_create_iv($bytes, MCRYPT_DEV_URANDOM));
        }

        if (null === $token) {
            $token = mb_substr($token, 0, $length, mb_detect_encoding($token));
        }

        return $token;
    }
}

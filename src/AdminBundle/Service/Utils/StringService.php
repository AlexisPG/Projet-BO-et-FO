<?php
/**
 * Created by PhpStorm.
 * User: wamobi14
 * Date: 12/01/17
 * Time: 12:05
 */

namespace AdminBundle\Service\Utils;


class StringService
{
    public function generateUniqId()
    {
        $result = bin2hex(openssl_random_pseudo_bytes(16));
        return $result;
    }
}
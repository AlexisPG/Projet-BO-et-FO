<?php

/**
 * Created by PhpStorm.
 * User: wamobi14
 * Date: 27/01/17
 * Time: 09:44
 */
namespace Tests\AdminBundle\Service\Utils;

use AdminBundle\Service\Utils\StringService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StringServiceTest extends WebTestCase
{
    public function testGenerateUniqId()
    {
        $stringService = new StringService();
        $value = $stringService->generateUniqId();

        $this->assertEquals(32, strlen($value));

    }
}
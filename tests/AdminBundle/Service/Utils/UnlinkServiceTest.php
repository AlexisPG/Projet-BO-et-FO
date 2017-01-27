<?php
/**
 * Created by PhpStorm.
 * User: wamobi14
 * Date: 13/01/17
 * Time: 12:12
 */

namespace Test\AdminBundle\Service;

use AdminBundle\Service\UnlinkService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UnlinkServiceTest extends WebTestCase
{

//    private $upload_dir;
//
//    public function __construct($uploadDir)
//    {
//        $this->upload_dir = $uploadDir;
//    }
    public function testremove()
    {
        $container = $this->createClient()->getContainer();
        $uploadDir = $container->getParameter('upload_dir');

        $uploadDir = 'tests/';
        $file = 'tempsFile.txt';
        $unlinkService = new UnlinkService($uploadDir);

        file_put_contents($uploadDir . $file, 'content');

        $this->assertTrue(file_exists($uploadDir . $file));

        $unlinkService->remove($file);

        $this->assertTrue(!file_exists($uploadDir . $file));
        $this->assertFileNotExists($uploadDir . $file);


//        unlink($this->upload_dir . $file);
    }
}
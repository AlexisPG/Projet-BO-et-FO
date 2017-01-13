<?php
/**
 * Created by PhpStorm.
 * User: wamobi14
 * Date: 13/01/17
 * Time: 12:12
 */

namespace AdminBundle\Service;


class UnlinkService
{
    private $upload_dir;

    public function __construct($uploadDir)
    {
        $this->upload_dir = $uploadDir;
    }
    public function remove($file)
    {
        unlink($this->upload_dir . $file);
    }
}
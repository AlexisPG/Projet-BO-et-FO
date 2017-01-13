<?php

namespace AdminBundle\Service;


use AdminBundle\Service\Utils\StringService;

class UploadService
{
    private $stringUtilsService;
    private $uploadDir;

    public function __construct(StringService $stringService, $uploadDir)
    {
        $this->stringUtilsService = $stringService;
        $this->uploadDir = $uploadDir;
    }

    public function upload($image)
    {
        // service utils (pour générer un nom aléatoirement)
        //$serviceUtils = $this->get('admin.service.utils.string');

        $fileName = $this->stringUtilsService->generateUniqId();

        // création du nom de l'image
        $imageName = $fileName . '.' . $image->guessExtension();

        // transfert de l'image
        $image->move($this->uploadDir, $imageName);

        return $imageName;

    }

}
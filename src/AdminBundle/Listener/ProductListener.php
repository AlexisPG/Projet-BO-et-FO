<?php
/**
 * Created by PhpStorm.
 * User: wamobi14
 * Date: 12/01/17
 * Time: 09:48
 */

namespace AdminBundle\Listener;


use AdminBundle\Entity\Product;
use AdminBundle\Service\UploadService;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class ProductListener
{
    private $uploadService;
    private $defaultImg;
    private $unlinkService;
    private $imageOrigin;

    public function __construct(UploadService $uploadService, $defaultImgDeclare, $unlinkService)
    {
        $this->uploadService = $uploadService;
        $this->unlinkService = $unlinkService;
        $this->defaultImg = $defaultImgDeclare;
    }

    public function prePersist(Product $entity, LifecycleEventArgs $args)
    {
        $entity->setDateCreation(new \DateTime());
        $entity->setDateEdit(new \DateTime());

        // Récupération de l'image
        $image = $entity->getImage();
        if (is_null($image))
        {
            $name = $this->defaultImg;
        }
        else
        {
            // Nom unique dans la BDD
            $name = $this->uploadService->upload($image);
        }

        // insertion du nom du fichier image généré dans notre objet produit
        $entity->setImage($name);
    }

    public function preUpdate(Product $entity, LifecycleEventArgs $args)
    {
        $entity->setDateEdit(new \DateTime());

        // Récupération de l'image
        $image = $entity->getImage();

        // Mettre à jour avec l'image par défaut
        if (is_null($image))
        {
            if(is_null($this->imageOrigin))
            {
            $name = $this->defaultImg;
            }
            else
            {
                $name = $this->imageOrigin;
            }
        }
        else
        {
            if($this->imageOrigin !== $this->defaultImg)
            {
                $this->unlinkService->remove($this->imageOrigin);
            }
            // Nom unique dans la BDD
            $name = $this->uploadService->upload($image);
        }

        // insertion du nom du fichier image généré dans notre objet produit
        $entity->setImage($name);
    }

    public function postLoad(Product $entity, LifecycleEventArgs $args)
    {
        // Récupération de l'image
        $this->imageOrigin = $entity->getImage();
    }
    public function postRemove(Product $entity, LifecycleEventArgs $args)
    {
        if($this->imageOrigin !== $this->defaultImg)
        {
            $this->unlinkService->remove($this->imageOrigin);
        }
    }

}
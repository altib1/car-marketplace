<?php

namespace App\Repository;

use App\Entity\Shop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\FileUploader;

/**
 * @extends ServiceEntityRepository<Shop>
 */
class ShopRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shop::class);
    }

    public function add(Shop $entity, bool $flush = false, $form = null, FileUploader $fileUploader = null): void
    {
        if ($form && $fileUploader) {
            $this->handleFileUploads($form, $entity, $fileUploader);
        }

        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Shop $entity, bool $flush = false, $form = null, FileUploader $fileUploader = null): void
    {
        if ($form && $fileUploader) {
            $this->handleFileUploads($form, $entity, $fileUploader);
        }

        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Shop $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    private function handleFileUploads($form, Shop $shop, FileUploader $fileUploader): void
    {
        /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $imageFile */
        $imageFile = $form->get('backgroundImageFileName')->getData();

        if ($imageFile) {
            $imageFileName = $fileUploader->upload($imageFile, 'shop', false);
            $shop->setBackgroundImageFileName($imageFileName["filename"]);
        }

        /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $imageFile */
        $imageFile = $form->get('logoImageFileName')->getData();

        if ($imageFile) {
            $imageFileName = $fileUploader->upload($imageFile, 'shop', false);
            $shop->setLogoImageFileName($imageFileName["filename"]);
        }
    }
}

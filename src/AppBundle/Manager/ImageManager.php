<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Image;
use AppBundle\Repository\Interfaces\ImageRepositoryInterface;

class ImageManager
{
    /** @var ImageRepositoryInterface */
    private $repository;

    /**
     * ImageManager constructor.
     *
     * @param ImageRepositoryInterface $repository
     */
    public function __construct(ImageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns array of all Images
     *
     * @return Image[]
     */
    public function getAllImages()
    {
        return $this->repository->findAll();
    }

    /**
     * Finds Image by it's Id
     *
     * @param int $imageId
     * @return \AppBundle\Entity\Image|null
     */
    public function getImageById($imageId)
    {
        return $this->repository->findOneById($imageId);
    }

    /**
     * Removes image by it's id
     *
     * @param int $imageId
     */
    public function deleteImage($imageId)
    {
        $image = $this->getImageById($imageId);
        if ($image) {
            $this->repository->deleteById($imageId);
        }
    }
}
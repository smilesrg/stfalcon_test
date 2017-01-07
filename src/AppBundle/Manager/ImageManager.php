<?php

namespace AppBundle\Manager;

use AppBundle\Repository\Interfaces\ImageRepositoryInterface;

class ImageManager
{
    /** @var ImageRepositoryInterface */
    protected $repository;

    /**
     * ImageManager constructor.
     * @param ImageRepositoryInterface $repository
     */
    public function __construct(ImageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns array of all images
     *
     * @return array
     */
    public function getAllImages()
    {
        return $this->repository->findAll();
    }

    public function getImageById($imageId)
    {
        return $this->repository->findById($imageId);
    }
}
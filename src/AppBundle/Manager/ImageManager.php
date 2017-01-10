<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Image;
use AppBundle\Repository\Interfaces\ImageRepositoryInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class ImageManager
{
    /** @var ImageRepositoryInterface */
    private $repository;

    /** @var PaginatorInterface */
    private $paginator;

    /**
     * ImageManager constructor.
     *
     * @param ImageRepositoryInterface $repository
     */
    public function __construct(ImageRepositoryInterface $repository, PaginatorInterface $paginator)
    {
        $this->repository = $repository;
        $this->paginator = $paginator;
    }

    /**
     * Returns array of all Images
     *
     * @param $page
     * @param $perPage
     * @param null $tags
     * @return PaginationInterface
     */
    public function getAllImages($page, $perPage, $tags = null)
    {
        $imagesQb = $this->repository->findImagesQb($tags);

        return $this->paginator->paginate(
            $imagesQb, $page, $perPage
        );
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
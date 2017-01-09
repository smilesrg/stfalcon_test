<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 09.01.17
 * Time: 15:25
 */

namespace AppBundle\Manager;

use AppBundle\Repository\Interfaces\ImageTagRepositoryInterface;

class ImageTagManager
{
    /** @var ImageTagRepositoryInterface */
    private $repository;

    /**
     * ImageManager constructor.
     *
     * @param ImageTagRepositoryInterface $repository
     */
    public function __construct(ImageTagRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns array of all tags
     *
     * @return array
     */
    public function getAllTags()
    {
        return $this->repository->findAllTagNames();
    }
}
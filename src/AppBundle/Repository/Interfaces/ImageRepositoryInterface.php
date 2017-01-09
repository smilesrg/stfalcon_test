<?php

namespace AppBundle\Repository\Interfaces;

use AppBundle\Entity\Image;

interface ImageRepositoryInterface
{
    /**
     * Finds all images in the repository.
     *
     * @return array The Images.
     */
    public function findAll();

    /**
     * Finds Image by it's Id.
     *
     * @param int $id
     * @return Image|null
     */
    public function findOneById($id);

    /**
     * Delete image by id.
     *
     * @param int $id
     */
    public function deleteById($id);
}
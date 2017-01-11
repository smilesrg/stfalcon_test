<?php

namespace AppBundle\Repository\Interfaces;

use AppBundle\Entity\Image;

interface ImageRepositoryInterface
{
    /**
     * Finds all images in the repository.
     *
     * @param array|null $tags
     * @return array The Images.
     */
    public function findImagesQb($tags = null);

    /**
     * Finds Image by it's Id.
     *
     * @param int $id
     * @return Image|null
     */
    public function findOneById($id);

    /**
     * Updates an image and store it to the database.
     *
     * @param Image $image
     * @return mixed
     */
    public function update(Image $image);

    /**
     * Delete image by id.
     *
     * @param int $id
     */
    public function deleteById($id);
}
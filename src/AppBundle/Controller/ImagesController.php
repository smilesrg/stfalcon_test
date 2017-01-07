<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class ImagesController
{
    /**
     * @Rest\View
     *
     * @param Image $image
     * @return array
     */
    public function getImagesAction()
    {

    }

    /**
     * @Rest\View
     *
     * @param Image $image
     * @return Image
     */
    public function getImageAction(Image $image)
    {
        return $image;
    }

    /**
     * @Rest\View
     *
     * @param Request $request
     * @return array
     */
    public function postImageAction(Request $request)
    {

    }

    /**
     * @Rest\View
     *
     * @param Request $request
     * @return array
     */
    public function patchImageAction(Request $request)
    {

    }

    /**
     * @Rest\View(statusCode=204)
     *
     * @param integer $imageId
     * @return array
     */
    public function deleteImageAction($imageId)
    {

    }
}
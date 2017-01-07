<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ImagesController extends FOSRestController
{
    /**
     * @ApiDoc(
     *   description = "Gets all images",
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     * @Rest\View
     *
     * @param Image $image
     * @return array
     */
    public function getImagesAction()
    {
        return $this->get('image.manager')->getAllImages();
    }

    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets an Image for a given id",
     *   output = "AppBundle\Entity\Image",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the image is not found"
     *   }
     * )
     *
     * @Rest\View
     *
     * @param int $imageId
     * @return Image
     *
     * @throws NotFoundHttpException when image does not exist
     */
    public function getImageAction($imageId)
    {
        $image = $this->get('image.manager')->getImageById($imageId);
        if (!$image) {
            throw new NotFoundHttpException("Image with id $imageId is not found");
        }

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
<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Form\ImageType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ImagesController extends FOSRestController
{
    /**
     * @ApiDoc(
     *   section = "Images",
     *   description = "Get all images",
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     * @Rest\QueryParam(name="page", requirements="\d+", default="1", description="Page number.")
     * @Rest\QueryParam(name="perPage", requirements="[1-50]+", default="1", description="Limit per page.")
     * @Rest\QueryParam(map=true, name="tags", description="Filter by tags.")
     * @Rest\View
     *
     * @param Image $image
     * @return array
     */
    public function getImagesAction($page, $perPage, $tags)
    {
        return $this->get('image.manager')->getAllImages($page, $perPage, $tags);
    }

    /**
     * @ApiDoc(
     *   section = "Images",
     *   description = "Get an Image with given id",
     *   output = "AppBundle\Entity\Image",
     *   requirements={
     *      {
     *          "name"="imageId",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Image Id"
     *      }
     *   },
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
        return $this->findImageById($imageId);
    }

    /**
     * @ApiDoc(
     *   section = "Images",
     *   description = "Create a new Image",
     *   output = "AppBundle\Entity\Image",
     *   statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when invalid data has been provided"
     *   },
     *   parameters={
     *      {"name"="title", "dataType"="string", "required"=true, "description"="Image Title"},
     *      {"name"="description", "dataType"="string", "required"=true, "description"="Image Description"},
     *      {"name"="tags", "dataType"="array", "required"=false, "description"="Tags"}
     *   }
     * )
     *
     * @Rest\View(statusCode=201)
     *
     * @param Request $request
     * @return array
     */
    public function postImageAction(Request $request)
    {
        return $this->get('image.form.handler')->handleForm($request, new Image());
    }

    /**
     * @ApiDoc(
     *   section = "Images",
     *   description = "Upload a file to the Image",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when invalid data has been provided"
     *   },
     *   parameters={
     *      {"name"="imageFile", "dataType"="file", "required"=true, "description"="Image File"}
     *   }
     * )
     * @Rest\FileParam(name="imageFile", image=true)
     * @Rest\View(statusCode=201)
     * @Rest\Post("/images/{imageId}/file")
     * @param $imageId
     * @param $imageFile
     * @return array
     * @internal param Request $request
     */
    public function postImageFileAction($imageId, $imageFile)
    {
        $image = $this->findImageById($imageId);

        $image->setImageFile($imageFile);

        $this->get('image.manager')->updateImage($image);
    }

    /**
     * @ApiDoc(
     *   section = "Images",
     *   description = "Download Image File",
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     * @Rest\View
     *
     * @param $imageId
     * @return BinaryFileResponse
     * @internal param Request $request
     * @internal param $imageFile
     */
    public function getImageFileAction($imageId)
    {
        $image = $this->findImageById($imageId);

        if (empty($image->getImageFile())) {
            throw new NotFoundHttpException("Image has no file");
        }

        return new BinaryFileResponse($image->getImageFile());
    }

    /**
     * @ApiDoc(
     *   section = "Images",
     *   description = "Update an Image partially",
     *   output = "AppBundle\Entity\Image",
     *   requirements={
     *      {
     *          "name"="imageId",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Image Id"
     *      }
     *   },
     *   parameters = {
     *      {"name"="title", "dataType"="string", "required"=true, "description"="Image Title"},
     *      {"name"="description", "dataType"="string", "required"=true, "description"="Image Description"},
     *      {"name"="tags", "dataType"="array", "required"=false, "description"="Tags"}
     *   },
     *   statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when invalid data has been provided",
     *     404 = "Returned when Image is not found"
     *   }
     * )
     * @Rest\View
     *
     * @param Request $request
     * @param int $imageId
     * @return Image|Form
     */
    public function patchImageAction(Request $request, $imageId)
    {
        $image = $this->findImageById($imageId);

        return $this->get('image.form.handler')->handleForm($request, $image);
    }

    /**
     * @ApiDoc(
     *   section = "Images",
     *   description = "Remove an Image completely",
     *   requirements={
     *      {
     *          "name"="imageId",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Image Id"
     *      }
     *   },
     *   statusCodes = {
     *     204 = "Returned when successful"
     *   }
     * )
     * @Rest\View(statusCode=204)
     *
     * @param integer $imageId
     */
    public function deleteImageAction($imageId)
    {
        $this->get('image.manager')->deleteImage($imageId);
    }

    /**
     * Finds image by Id. If not found, thows NotFoundHttpException
     *
     * @param int $imageId
     * @throws NotFoundHttpException
     * @return Image
     */
    private function findImageById($imageId)
    {
        $image = $this->get('image.manager')->getImageById($imageId);
        if (!$image) {
            throw new NotFoundHttpException("Image with id $imageId does not exists");
        }

        return $image;
    }

}
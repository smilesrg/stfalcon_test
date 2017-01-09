<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ImageTagsController extends FOSRestController
{
    /**
     * @ApiDoc(
     *   section = "Tags",
     *   description = "Gets all tags",
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     * @Rest\View
     *
     * @param Image $image
     * @return array
     */
    public function getImageTagsAction()
    {
       return $this->get('image_tag.manager')->getAllTags();
    }
}
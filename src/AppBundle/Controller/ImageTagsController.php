<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ImageTagsController
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
       return new JsonResponse();
    }
}
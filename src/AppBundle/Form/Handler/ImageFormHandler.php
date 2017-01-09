<?php

namespace AppBundle\Form\Handler;

use AppBundle\Entity\Image;
use AppBundle\Form\ImageType;
use AppBundle\Repository\Interfaces\ImageRepositoryInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;

class ImageFormHandler
{
    /** @var  ObjectManager */
    private $om;

    /** @var FormFactoryInterface */
    private $formFactory;

    public function __construct(ObjectManager $om, FormFactoryInterface $formFactory)
    {
        $this->om = $om;
        $this->formFactory = $formFactory;
    }

    /**
     * Handle form submission.
     *
     * @param Request $request
     * @param Image $image
     * @return Image|\Symfony\Component\Form\FormInterface
     */
    public function handleForm(Request $request, Image $image)
    {
        $form = $this->formFactory->create(ImageType::class, $image);

        $patch = $request->getMethod() == Request::METHOD_PATCH ? true : false;

        $form->submit($request->request->all(), $patch);

        if (!$form->isValid()) {
            return $form;
        }

        $this->om->persist($image);
        $this->om->flush();

        return $image;
    }
}
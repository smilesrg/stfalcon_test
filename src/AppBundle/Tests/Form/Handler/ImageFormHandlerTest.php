<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 11.01.17
 * Time: 11:14
 */

namespace AppBundle\Tests\Form\Handler;

use AppBundle\Entity\Image;
use AppBundle\Form\Handler\ImageFormHandler;
use AppBundle\Form\ImageType;
use Doctrine\Common\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class ImageFormHandlerTest extends TestCase
{
    /**
     * Submitting a valid form
     */
    public function testHandleValidForm()
    {
        $image = $this->createMock(Image::class);
        $om = $this->createMock(ObjectManager::class);
        $formFactory = $this->createMock(FormFactory::class);
        $form = $this->createMock(Form::class);

        $formFactory
            ->method('create')
            ->willReturn($form);

        $formHandler = new ImageFormHandler($om, $formFactory);

        $form->method('isValid')
            ->willReturn(true);

        $result = $formHandler->handleForm(new Request(), $image);

        $this->assertEquals($image, $result);
    }

    /**
     * Submitting an invalid form
     */
    public function testHandleInvalidForm()
    {
        $image = $this->createMock(Image::class);
        $om = $this->createMock(ObjectManager::class);
        $formFactory = $this->createMock(FormFactory::class);
        $form = $this->createMock(Form::class);

        $formFactory
            ->method('create')
            ->willReturn($form);

        $formHandler = new ImageFormHandler($om, $formFactory);

        $form->method('isValid')
            ->willReturn(false);

        $result = $formHandler->handleForm(new Request(), $image);

        $this->assertEquals($form, $result);
    }
}
<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Image;
use AppBundle\Entity\ImageTag;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;

class LoadImagesData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    const IMAGES_COUNT = 5;
    const TAGS_COUNT = 5;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    public function load(ObjectManager $manager)
    {
        $faker = $this->container->get('davidbadura_faker.faker');

        for ($i = 0; $i < self::IMAGES_COUNT; $i++) {
            $image = new Image();
            $image->setTitle($faker->word);
            $image->setDescription($faker->text);
            $image->setImageName("$i.jpg");
            $index = rand(1, count(LoadImageTagsData::$tagNames));
            $image->addTag($this->getReference("image_tag_$index"));
            $manager->persist($image);
        }

        $manager->flush();
    }


    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        //Make possibility to insert fixtures between this one and tags - just for a case
        return 20;
    }
}
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

class LoadImageTagsData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    public static $tagNames = ['first', 'second', 'third', 'fourth', 'fifth'];

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
        foreach (self::$tagNames as $index => $name) {
            $imageTag = new ImageTag();
            $imageTag->setName($name);
            $manager->persist($imageTag);
            $manager->flush();
            $this->addReference("image_tag_$index", $imageTag);
        }
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        //Make possibility to insert fixtures before this one - just for a case
        return 10;
    }
}
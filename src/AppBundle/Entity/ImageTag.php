<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Image;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * ImageTag
 *
 * @ORM\Table(name="image_tags")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ORM\ImageTagRepository")
 * @JMS\ExclusionPolicy("all")
 */
class ImageTag
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64, unique=true)
     * @JMS\Expose
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Image", mappedBy="tags")
     */
    private $images;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ImageTag
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add images
     *
     * @param Image $image
     * @return ImageTag
     */
    public function addImage(Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove images
     *
     * @param Image $image
     */
    public function removeImage(Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }
}

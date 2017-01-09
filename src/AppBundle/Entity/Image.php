<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use AppBundle\Entity\ImageTag;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Image
 *
 * @ORM\Table(name="images")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ORM\ImageRepository")
 * @JMS\ExclusionPolicy("all")
 * @Vich\Uploadable
 */
class Image
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
     * @ORM\Column(name="title", type="string", length=64)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 64,
     *      minMessage = "Image title must be at least {{ limit }} characters long",
     *      maxMessage = "Image title cannot be longer than {{ limit }} characters"
     * )
     * @JMS\Expose
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=512)
     * @Assert\Length(
     *      min = 2,
     *      max = 512,
     *      minMessage = "Image description must be at least {{ limit }} characters long",
     *      maxMessage = "Image description cannot be longer than {{ limit }} characters"
     * )
     * @JMS\Expose
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\ReadOnly
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @JMS\Expose
     * @JMS\ReadOnly
     */
    private $updatedAt;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="image", fileNameProperty="imageName")
     *
     * @var File
     * @Assert\Image()
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\ManyToMany(targetEntity="ImageTag", inversedBy="images", cascade={"persist"})
     * @ORM\JoinTable(name="images_to_image_tags")
     * @JMS\Expose
     * @JMS\Type("array<string>")
     * @JMS\Accessor(getter="getTagsAsVector")
     */
    private $tags;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Image
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Image
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Image
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return Image
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
    }


    /**
     * Add tags
     *
     * @param \AppBundle\Entity\ImageTag $tag
     * @return Image
     */
    public function addTag(ImageTag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \AppBundle\Entity\ImageTag $tag
     */
    public function removeTag(ImageTag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return ArrayCollection
     */
    public function getTagsAsVector()
    {
        $result = new ArrayCollection();

        foreach ($this->getTags() as $tag) {
            $result->add($tag->getName());
        }

        return $result;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }
}

<?php

namespace AppBundle\Repository\ORM;

use AppBundle\Entity\Image;
use AppBundle\Repository\Interfaces\ImageRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * ImageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImageRepository extends EntityRepository implements ImageRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findOneById($id)
    {
        return parent::findOneById($id);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($id)
    {
        $image = $this->findOneById($id);

        if ($image) {
            $this->getEntityManager()->remove($image);
            $this->getEntityManager()->flush();
        }
    }

    public function update(Image $image)
    {
        $this->getEntityManager()->persist($image);
        $this->getEntityManager()->flush();
    }

    /**
     * Query builder for finding images, filtering by tags
     */
    public function findImagesQb($tags = null)
    {
        $qb = $this->createQueryBuilder('i');

        if ($tags) {
            $qb->join('i.tags', 'tag')
               ->where('tag.name IN (:tags)')
                ->setParameter('tags', $tags);
        }

        return $qb;
    }
}

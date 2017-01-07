<?php

namespace AppBundle\Repository\ORM;

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
    public function findById($id)
    {
        return $this->findBy(['id' => $id]);
    }
}
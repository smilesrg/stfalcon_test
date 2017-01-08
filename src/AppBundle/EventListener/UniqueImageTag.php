<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Image;
use AppBundle\Entity\ImageTag;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * {@link http://stackoverflow.com/questions/21280011/prevent-duplicates-in-the-database-in-a-many-to-many-relationship}
 */
class UniqueImageTag
{
    /**
     * This will be called on newly created entities
     */
    public function prePersist(LifecycleEventArgs $args)
    {

        $entity = $args->getEntity();

        // we're interested in Iamge only
        if ($entity instanceof Image) {
            $entityManager = $args->getEntityManager();
            $tags = $entity->getTags();

            foreach($tags as $key => $tag){

                // let's check for existance of this tag
                $results = $entityManager->getRepository(ImageTag::class)
                    ->findBy(array('name' => $tag->getName()), array('id' => 'ASC') );

                // if tag exists use the existing tag
                if (count($results)) {
                    $tags[$key] = $results[0];
                }
            }
        }
    }

    /**
     * Called on updates of existent entities
     *
     * New tags were already created and persisted (although not flushed)
     * so we decide now wether to add them to Images or delete the duplicated ones
     */
    public function preUpdate(LifecycleEventArgs $args)
    {

        $entity = $args->getEntity();

        // we're interested in Images only
        if ($entity instanceof Image) {
            $entityManager = $args->getEntityManager();
            $tags = $entity->getIngredients();

            foreach($tags as $tag) {

                // let's check for existence of this tag
                // find by name and sort by id keep the older tag first
                $results = $entityManager->getRepository(ImageTag::class)
                    ->findBy(array('name' => $tag->getName()), array('id' => 'ASC') );

                // if ingredient exists at least two rows will be returned
                // keep the first and discard the second
                if (count($results) > 1) {
                    $knownTag = $results[0];
                    $entity->addTag($knownTag);

                    // remove the duplicated ingredient
                    $duplicatedTag = $results[1];
                    $entityManager->remove($duplicatedTag);
                }else{
                    // tag doesn't exist yet, add relation
                    $entity->addTag($tag);
                }
            }
        }
    }

}
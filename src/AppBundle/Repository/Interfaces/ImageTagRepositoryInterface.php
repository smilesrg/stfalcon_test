<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 09.01.17
 * Time: 15:27
 */

namespace AppBundle\Repository\Interfaces;


interface ImageTagRepositoryInterface
{
    /**
     * Get all tag names as an array (vector)
     *
     * @return string[]
     */
    public function findAllTagNames();
}
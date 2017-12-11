<?php

namespace AppBundle\Repository;

/**
 * categoryRepository
 *
 */

class categoryRepository extends \Doctrine\ORM\EntityRepository
{
    public function rawGetAll()
    {
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare('SELECT * FROM category');
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getMainCategories(){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM AppBundle:category p WHERE p.parent IS NULL '
            )
            ->getResult();
    }

    public function getChildrenOfCategory($parent){
        return $this->getEntityManager()
            ->createQuery(
                "SELECT p FROM AppBundle:category p WHERE p.parent=$parent "
            )
            ->getResult();
    }
}
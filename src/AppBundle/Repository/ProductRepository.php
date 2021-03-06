<?php

namespace AppBundle\Repository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends \Doctrine\ORM\EntityRepository
{
    public function getProductsByCategory($categoryId){
        return $this->getEntityManager()
            ->createQuery(
                "SELECT p FROM AppBundle:Product p WHERE p.categoryId = $categoryId"
            )
            ->getResult();
    }
}

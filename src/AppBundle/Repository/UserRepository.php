<?php

namespace AppBundle\Repository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function CheckIfFirst(){
        // TO DO
    }
    public function getUsersForPagination(){
       $q = $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM AppBundle:User p WHERE p.isBanned IS NULL '
            )
           ->setFirstResult(0)
           ->setMaxResults(2);

        $paginator = new Paginator($q);
        return $paginator;
    }
}

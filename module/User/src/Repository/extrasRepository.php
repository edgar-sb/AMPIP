<?php


namespace User\Repository;

use User\Entity\extrasEntity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class extrasRepository extends EntityRepository
{
    /**
     * Retrieves all users in descending dateCreated order.
     * @return Query
     */

    public function getDataUser($id){
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('u')
            ->from(extrasEntity::class, 'u')
            ->where('u.id', '$1')
            ->setParameter(1,$id)
            ->orderBy('u.id', 'DESC');

        $arr = $queryBuilder->getQuery();

        $js = json_encode($arr);
        return $js;
    }

}
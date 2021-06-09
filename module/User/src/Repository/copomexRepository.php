<?php


namespace copomex\Repository;
use Doctrine\ORM\EntityRepository;
use User\Entity\corpEntity;
use Doctrine\ORM\Query;

class copomexRepository extends EntityRepository
{
    /**
     * Retrieves all users in descending dateCreated order.
     * @return Query
     */

    public function getCopomex(){
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('u')
            ->from(copomexEntity::class, 'u')
            ->orderBy('u.id', 'DESC');

        $arr = $queryBuilder->getQuery()->toArray();

        $js = json_encode($arr);
        return $js;
    }

   

}
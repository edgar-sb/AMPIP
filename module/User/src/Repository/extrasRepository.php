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

    public function updateData($campo,$valor, $id){
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->update(extrasEntity::class,'u')
            ->set('u'.$campo, '?1')
            ->setParameter(1,$valor)
            ->where('u.id_entity = ?2')
            ->setParameter(2, $id)
            ->getQuery()

            ->getSingleScalarResult();
        return true;
    }

}
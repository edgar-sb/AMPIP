<?php


namespace User\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use User\Entity\spacesEntity;

class spaces extends EntityRepository
{
    /**
     * Retrieves all users in descending dateCreated order.
     * @return Query
     */
    public function getAllRole(){
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('u')
            ->from(spacesEntity::class, 'u')
            ->orderBy('u.id', 'DESC');
        $queryBuilder->getQuery();

        $arr = Array();
        $roleList = [];
        foreach ($queryBuilder as $role) {
            if ($role->getId() != "") {
                $roleList["id"] = $role->getId();

            } else {
                $roleList["error"] = "2541";
            }
        }

        return $roleList;
    }

}
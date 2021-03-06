<?php

namespace Bilan_Social\Bundle\ReferencielBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Bilan_Social\Bundle\CoreBundle\Repository\AbstractRepository;
/**
 * RefDomaineDiplomeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RefDomaineDiplomeRepository extends RefAbstractRepository {
    
    public function findByAllWithOrder() {

        $qb = $this->_em->createQueryBuilder();
        $qb->select('met')
                ->from($this->_entityName, 'met')
                ->andWhere('met.blVali = 0')
                ->addOrderBy('met.idDomaineDiplome', 'ASC')
        ;

        try {
            $ce = $qb->getQuery()->getResult();
        }
        catch (NoResultException $e) {
            // Pas de bilan pour cette enquete et coll
            return null;
        }

        return $ce;
    }
}
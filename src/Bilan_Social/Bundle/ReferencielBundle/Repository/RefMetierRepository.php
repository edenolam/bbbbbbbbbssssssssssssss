<?php

namespace Bilan_Social\Bundle\ReferencielBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Bilan_Social\Bundle\CoreBundle\Repository\AbstractRepository;
/**
 * RefMetierRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RefMetierRepository extends RefAbstractRepository {

    public function getAllWithOrder($familleMetier = null) {

        $qb = $this->_em->createQueryBuilder();
        $qb->select('met')
                ->from($this->_entityName, 'met')
                ->where('met.blVali = 0')
                ->addOrderBy('met.blMetiPrinc', 'DESC')
        ;
 

        if ($familleMetier != null) {
            $qb->innerJoin('met.RefFamilleMetier', 'rfm', 'rfm.idFamilleMetier = met.idFamilleMetier');
            $qb->andWhere('met.RefFamilleMetier = :familleMetier')
                    ->setParameter('familleMetier', $familleMetier);
        }
        try {
           
            $ce = $qb->getQuery()->getResult();
        } catch (NoResultException $e) {
            // Pas de bilan pour cette enquete et coll
            return null;
        }

        return $ce;
    }

    public function findByAllWithOrder() {

        $qb = $this->_em->createQueryBuilder();
        $qb->select('met')
                ->from($this->_entityName, 'met')
                ->innerJoin('met.RefFamilleMetier', 'f', 'f.idFamilleMetier = met.idFamilleMetier')
                ->andWhere('met.blVali = 0')
                //->andWhere('f.idFamilleMetier= 1')
                ->addOrderBy('f.idFamilleMetier', 'ASC')
                ->addOrderBy('met.idMetier', 'ASC')
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

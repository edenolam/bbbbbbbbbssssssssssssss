<?php

namespace Bilan_Social\Bundle\ReferencielBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Bilan_Social\Bundle\CoreBundle\Repository\AbstractRepository;
/**
 * RefSpecialiteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RefSpecialiteRepository extends RefAbstractRepository {

    public function getAllWithOrder($domaineSpecialite = null) {

        $qb = $this->_em->createQueryBuilder();
        $qb->select('spe')
                ->from($this->_entityName, 'spe')
                ->where('spe.blVali = 0')
        ;


        if ($domaineSpecialite != null) {
            $qb->innerJoin('spe.refDomaineSpecialite', 'rds', 'rds.idDomaineSpecialite = spe.idDomaineSpecialite');
            $qb->andWhere('spe.refDomaineSpecialite = :domaineSpecialite')
                    ->setParameter('domaineSpecialite', $domaineSpecialite);
        }
        try {

            $ce = $qb->getQuery()->getResult();
        }
        catch (NoResultException $e) {
            // Pas de bilan pour cette enquete et coll
            return null;
        }

        return $ce;
    }

    public function findByAllWithOrder() {

        $qb = $this->_em->createQueryBuilder();
        $qb->select('met')
                ->from($this->_entityName, 'met')
                ->innerJoin('met.refDomaineSpecialite', 'f', 'f.idDomaineSpecialite = met.idDomaineSpecialite')
                ->andWhere('met.blVali = 0')
                //->andWhere('f.idFamilleMetier= 1')
                ->addOrderBy('f.idDomaineSpecialite', 'ASC')
                ->addOrderBy('met.idSpecialite', 'ASC')
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
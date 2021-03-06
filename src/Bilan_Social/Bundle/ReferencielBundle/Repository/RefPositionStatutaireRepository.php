<?php

namespace Bilan_Social\Bundle\ReferencielBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Bilan_Social\Bundle\UserBundle\Repository\UserRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\NonUniqueResultException;
use Bilan_Social\Bundle\CoreBundle\Repository\AbstractRepository;
/**
 * RefPositionStatutaireRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RefPositionStatutaireRepository extends RefAbstractRepository {

    public function findByAllWithOrder() {

        $qb = $this->_em->createQueryBuilder();
        $qb->select('ps')
                ->from($this->_entityName, 'ps')
                ->leftJoin('ps.refGroupePositionStatutaire', 'g')
                ->addSelect('g')
                ->where('ps.blVali = 0')
                ->addOrderBy('g.idGrouPosistat', 'ASC')
                ->addOrderBy('ps.idPosistat', 'ASC')
        ;

        try {
            $ce = $qb->getQuery()->getResult();
        } catch (NoResultException $e) {
            return null;
        }

        return $ce;
    }


    public function findForInd142WithOrder() {

        $qb = $this->_em->createQueryBuilder();
        $qb->select('ps')
                ->from($this->_entityName, 'ps')
                ->where('ps.blVali = 0')
                ->andWhere('ps.blInd142 = 1')
                ->addOrderBy('ps.idPosistat', 'ASC')
                ;

        try {
            $ce = $qb->getQuery()->getResult();
        }
        catch (NoResultException $e) {
            return null;
        }

        return $ce;

    }

    public function findForInd143WithOrder() {

        $qb = $this->_em->createQueryBuilder();
        $qb->select('ps')
                ->from($this->_entityName, 'ps')
                ->where('ps.blVali = 0')
                ->andWhere('ps.blInd143 = 1')
                ->addOrderBy('ps.idPosistat', 'ASC')
                ;

        try {
            $ce = $qb->getQuery()->getResult();
        }
        catch (NoResultException $e) {
            return null;
        }

        return $ce;

    }

    public function findForInd144WithOrder() {

        $qb = $this->_em->createQueryBuilder();
        $qb->select('ps')
                ->from($this->_entityName, 'ps')
                ->where('ps.blVali = 0')
                ->andWhere('ps.blInd144 = 1')
                ->addOrderBy('ps.idPosistat', 'ASC')
                ;

        try {
            $ce = $qb->getQuery()->getResult();
        }
        catch (NoResultException $e) {
            return null;
        }

        return $ce;

    }

    public function findByAllWithOrderAndStatut(array $params) {

        $statut = $params['statut'];
        $user = $params['user'];
        $blCdg = $this->_em->getRepository('UserBundle:User')->findOneByCdgCnfptByUsername($user);

        $qb = $this->_em->createQueryBuilder();
        $qb->select('ps')
                ->from($this->_entityName, 'ps')
                ->leftJoin('ps.refGroupePositionStatutaire', 'g')
                ->innerJoin('ps.statutPositionStatutaires', 's', 'ps.statutPositionStatutaires = s.idStat')
                ->addSelect('g')
                ->where('ps.blVali = 0');

        if (!empty($statut)) {
                $qb->andWhere('s.idStat = :idStatut')
                    ->setParameter('idStatut', $statut);
        }

//        if (!$blCdg) {
//            $qb->andWhere('ps.blCdg = :blCdg')
//                ->setParameter('blCdg', 0);
//        }
//
        $qb->addOrderBy('g.idGrouPosistat', 'ASC')
                ->addOrderBy('ps.idPosistat', 'ASC');

        try {
            $ce = $qb->getQuery()->getResult();
        } catch (NoResultException $e) {
            return null;
        }

        return $ce;
    }

    public function findOneByInCdN4ds($cdN4ds) {
        $code = '%-'.$cdN4ds.'-%';
        $qb = $this->_em->createQueryBuilder();
        $qb->select('ps')
                ->from($this->_entityName, 'ps')
                ->where('ps.blVali = 0')
                ->andWhere('concat(concat(\'-\', ps.cdMotiN4ds), \'-\' ) LIKE :code')
                ->setParameter('code', $code)
                ;

        try {
            $ps = $qb->getQuery()->getSingleResult();
        }
        catch (NoResultException $e) {
            return null;
        }
        catch (NonUniqueResultException $e) {
            return null;
        }

        return $ps;

    }

}

<?php

namespace Bilan_Social\Bundle\ConsoBundle\Repository;
use Bilan_Social\Bundle\CoreBundle\Repository\AbstractRepository;

/**
 * BscRassctMaladieProCaracProRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BscRassctMaladieProCaracProRepository extends AbstractRepository {

    public function getResultsForExport($idsBsc) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('ref.lbMaladiepro, SUM(bsch.rMp1) AS rMp1, SUM(bsch.rMp2) AS rMp2')
                ->from($this->_entityName, 'bsch')
                ->join('ReferencielBundle:RefMaladieProfessionnelle', 'ref', 'WITH', 'bsch.refMaladieProfessionnelle = ref.idMaladiepro')
                ->where('bsch.bilanSocialConsolide IN (:idsBsc)')
                ->setParameter('idsBsc', $idsBsc)
                ->groupBy('bsch.refMaladieProfessionnelle');

        $qb2 = $this->_em->createQueryBuilder();
        $qb2->select("ref.lbMaladiepro, 0 AS rMp1, 0 AS rMp2")
            #->addSelect('reff')
            ->from('ReferencielBundle:RefMaladieProfessionnelle', 'ref')
            ->where('ref.blVali = 0')
            ->orderBy('ref.nmOrdre');

        try {
            $result = $this->unionQbs($qb2,$qb,array('lbMaladiepro'));
            /*$result = $qb->getQuery()->getResult();
            $result = $this->utf8_encode($result);*/
        }
        catch (NoResultException $e) {
            // Pas de enquete active consolidé pour la collectivite
            $result = null;
        }

        return $result;
    }

}

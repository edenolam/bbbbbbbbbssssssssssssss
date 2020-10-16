<?php

namespace Bilan_Social\Bundle\ConsoBundle\Repository;
use Bilan_Social\Bundle\CoreBundle\Repository\AbstractRepository;

/**
 * BscHanditorialStatutAgentsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BscHanditorialStatutAgentsRepository extends AbstractRepository {

    public function getResultsForExport($idsBsc) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('ref.lbStat, SUM(bsch.statutAgentH) AS statutAgentH, SUM(bsch.statutAgentF) AS statutAgentF')
                ->from($this->_entityName, 'bsch')
                ->join('ReferencielBundle:RefStatut', 'ref', 'WITH', 'bsch.refStatut = ref.idStat')
                ->where('bsch.bilanSocialConsolide IN (:idsBsc)')
                ->setParameter('idsBsc', $idsBsc)
                ->groupBy('bsch.refStatut');

        $qb2 = $this->_em->createQueryBuilder();
        $qb2->select("ref.lbStat, 0 AS statutAgentH, 0 AS statutAgentF")
            #->addSelect('reff')
            ->from('ReferencielBundle:RefStatut', 'ref')
            ->where('ref.blVali = 0')
            ->orderBy('ref.nmOrdre');

        try {
            $result = $this->unionQbs($qb2,$qb,array('lbStat'));
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

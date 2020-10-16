<?php

namespace Bilan_Social\Bundle\ConsoBundle\Repository;
use Bilan_Social\Bundle\CoreBundle\Repository\AbstractRepository;
/**
 * BscHanditorialInaptEtReclaMetiersRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BscHanditorialInaptEtReclaMetiersRepository extends AbstractRepository
{
	public function getResultsForExport($idsBsc) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('ref as refMetier, SUM(bsch.metierH) AS metierH, SUM(bsch.metierF) AS metierF')
                ->from($this->_entityName, 'bsch')
                ->join('ReferencielBundle:RefMetier', 'ref', 'WITH', 'bsch.refMetier = ref.idMetier')
                ->where('bsch.bilanSocialConsolide IN (:idsBsc)')
                ->setParameter('idsBsc', $idsBsc)
                ->groupBy('bsch.refMetier');
        try {
            $result = $qb->getQuery()->getResult();
            $result = $this->utf8_encode($result);
        }
        catch (NoResultException $e) {
            // Pas de enquete active consolidé pour la collectivite
            $result = null;
        }

        return $result;
    }
}

<?php

namespace Bilan_Social\Bundle\ConsoBundle\Repository;
use Bilan_Social\Bundle\CoreBundle\Repository\AbstractRepository;
/**
 * BscHanditorialInaptEtReclaCadreEmploisRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BscHanditorialInaptEtReclaCadreEmploisRepository extends AbstractRepository
{
	public function getResultsForExport($idsBsc) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('ref as refCadreEmploi, SUM(bsch.cadreEmploiH) AS cadreEmploiH, SUM(bsch.cadreEmploiF) AS cadreEmploiF')
            ->addSelect('reff')
                ->from($this->_entityName, 'bsch')
                ->join('ReferencielBundle:RefCadreEmploi', 'ref', 'WITH', 'bsch.refCadreEmploi = ref.idCadrempl')
                ->join('ref.refFiliere', 'reff', 'WITH', 'ref.refFiliere = reff.idFili')
                ->where('bsch.bilanSocialConsolide IN (:idsBsc)')
                ->setParameter('idsBsc', $idsBsc)
                ->groupBy('bsch.refCadreEmploi')
                ->addGroupBy('ref.refFiliere');
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

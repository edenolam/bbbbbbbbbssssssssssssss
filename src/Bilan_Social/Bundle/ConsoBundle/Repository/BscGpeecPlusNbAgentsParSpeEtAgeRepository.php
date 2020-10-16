<?php

namespace Bilan_Social\Bundle\ConsoBundle\Repository;
use Bilan_Social\Bundle\CoreBundle\Repository\AbstractRepository;

/**
 * BscGpeecPlusNbAgentsParSpeEtAgeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BscGpeecPlusNbAgentsParSpeEtAgeRepository extends AbstractRepository {

    public function getResultsForExport($idsBsc) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('ref as refSpecialite, SUM(bsch.rNb1) AS rNb1, SUM(bsch.rNb2) AS rNb2, SUM(bsch.rNb3) AS rNb3, SUM(bsch.rNb4) AS rNb4, SUM(bsch.rNb5) AS rNb5, SUM(bsch.rNb6) AS rNb6, SUM(bsch.rNb7) AS rNb7, SUM(bsch.rNb8) AS rNb8, SUM(bsch.rNb9) AS rNb9, SUM(bsch.rNb10) AS rNb10')
                ->from($this->_entityName, 'bsch')
                ->join('ReferencielBundle:RefSpecialite', 'ref', 'WITH', 'bsch.refSpecialite = ref.idSpecialite')
                ->where('bsch.bilanSocialConsolide IN (:idsBsc)')
                ->setParameter('idsBsc', $idsBsc)
                ->groupBy('bsch.refSpecialite');
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

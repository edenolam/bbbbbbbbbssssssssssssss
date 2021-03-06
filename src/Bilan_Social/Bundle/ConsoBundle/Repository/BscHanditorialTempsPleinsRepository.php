<?php

namespace Bilan_Social\Bundle\ConsoBundle\Repository;
use Bilan_Social\Bundle\CoreBundle\Repository\AbstractRepository;

/**
 * BscHanditorialTempsPleinsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BscHanditorialTempsPleinsRepository extends AbstractRepository {

    public function getResultsForExport($idsBsc) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('
        COALESCE(SUM(bsch.tempsPleinH),0) AS tempsPleinH, 
        COALESCE(SUM(bsch.tempsPleinF),0) AS tempsPleinF, 
        COALESCE(SUM(bsch.tempsPartielH),0) AS tempsPartielH, 
        COALESCE(SUM(bsch.tempsPartielF),0) AS tempsPartielF')
                ->from($this->_entityName, 'bsch')
                ->where('bsch.bilanSocialConsolide IN (:idsBsc)')
                ->setParameter('idsBsc', $idsBsc);
        try {
            $result = $qb->getQuery()->getSingleResult();
            $result = $this->utf8_encode($result);
        }
        catch (NoResultException $e) {
            // Pas de enquete active consolidé pour la collectivite
            $result = null;
        }

        return $result;
    }

}

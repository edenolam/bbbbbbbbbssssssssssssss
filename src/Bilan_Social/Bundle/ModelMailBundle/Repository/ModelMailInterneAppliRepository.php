<?php

namespace Bilan_Social\Bundle\ModelMailBundle\Repository;

/**
 * ModelMailInterneAppliRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ModelMailInterneAppliRepository extends \Doctrine\ORM\EntityRepository
 {

    function findModelMailForCdg() {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('mm')
                ->from($this->_entityName, 'mm')
                ->where("mm.codeApp IN('DEVERROUILLEBLC', 'NEWQUESTIONCOLLECTIVITE', 'NEWREPONSE', 'REFUSBLC', 'REFUSMODIF', 'SOUMVALIDCOLL', 'TRANSBLC', 'VALIDEBLC', 'VALIDEMODIF')");
        return $qb->getQuery()->getResult();
    }

}

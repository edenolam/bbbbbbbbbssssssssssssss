<?php

namespace Bilan_Social\Bundle\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Bilan_Social\Bundle\UserBundle\Entity\User;

/**
 * exportAdminRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class exportAdminRepository extends EntityRepository {
    /*
     * type :
     *      collectivite : 1*
     *      departement : 2*
     */

    public function findExportByType($type, $user=null) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('ea')
            ->from('CoreBundle:exportAdmin','ea')
            ->where('ea.fgStat = 1')
            ->andWhere('ea.type = :type')
            ->setParameter('type', $type);

        if($user!=null && $user->hasRole('ROLE_INFOCENTRE')){
            $id_profil = $user->getProfils()->getIdProfil();
            $qb->join('ea.profils','p')
                ->andWhere('p.idProfil = :id_profil')
                ->setParameter('id_profil', $id_profil);
        }

            
        return $qb->getQuery()->execute();
    }

}

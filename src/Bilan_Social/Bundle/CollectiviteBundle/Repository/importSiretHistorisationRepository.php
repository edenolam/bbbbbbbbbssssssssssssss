<?php

namespace Bilan_Social\Bundle\CollectiviteBundle\Repository;

/**
 * importSiretHistorisationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */

use Bilan_Social\Bundle\CoreBundle\Repository\AbstractRepository;
use Bilan_Social\Bundle\ReferencielBundle\Enums\DroitsEnum;

class importSiretHistorisationRepository extends AbstractRepository
{
    public function getNewColl($utilisateur, $param) {
        $droit = bindec(DroitsEnum::MASK_READ_WRITE_COLLECTIVITE);
        $qb = $this->_em->createQueryBuilder();
        $qb->select('c.nmSire,c.ancienSiret, c.lbColl, c.lbAdre,c.lbVill, d.lbDepa, d.cdDepa' )
            ->from('UserBundle:UtilisateurDroits', 'ud')
            ->join('UserBundle:UtilisateurCdg', 'uc', 'WITH', 'ud.utilisateurCdg = uc.idUtilisateurCdg')
            ->join('CollectiviteBundle:CdgDepartement', 'cd', 'WITH', 'ud.cdgDepartement = cd.idCdgDepartement')
            ->join('CollectiviteBundle:Departement', 'd', 'WITH', 'd.idDepa = cd.departement')
            ->join('CollectiviteBundle:importSiretHistorisation', 'c', 'WITH', 'c.idDepa = d.cdDepa')
            ->where('uc.utilisateur = :idUtilisateur')
            ->andWhere('CONV(:mask, 2, 10, ud.fgDroits) = :droit') //CONV(:mask,2,10)
            ->andWhere('c.blPresent = :blPresent') // recupération des collectivités non presentes
            ->andWhere('c.blConfirmed = 0') // recupération des collectivités non traitées
            ->setParameter('mask', DroitsEnum::MASK_READ_WRITE_COLLECTIVITE)
            ->setParameter('idUtilisateur', $utilisateur)
            ->setParameter('blPresent', $param)
            ->setParameter("droit", $droit);

        return $qb->getQuery()->getArrayResult();
    }
}

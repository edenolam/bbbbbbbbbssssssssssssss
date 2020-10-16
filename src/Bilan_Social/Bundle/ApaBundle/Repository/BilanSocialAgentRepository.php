<?php

namespace Bilan_Social\Bundle\ApaBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Bilan_Social\Bundle\ApaBundle\Entity\BilanSocialAgent;
use Bilan_Social\Bundle\UserBundle\Entity\User;
use Doctrine\ORM\NoResultException;

/**
 * BilanSocialAgent Repository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BilanSocialAgentRepository extends EntityRepository {

    public function GetAllAgents($idEnqu, $idColl, $codeStatus) {

        $qb = $this->_em->createQueryBuilder();
        $qb->select('ba')

                ->from($this->_entityName, 'ba')
                ->leftJoin('ba.refStatut', 's', 's.idStat = ba.idStat')
                ->leftJoin('ba.refMotifDepart', 'rmd', 'rmd.idMotiDepa = ba.idMotiDepa')
                ->leftJoin('ba.collectivite', 'c', 'c.idColl = ba.idColl')
                ->addSelect('s')
                ->addSelect('rmd')
                ->where('ba.enquete = :enquete')
                ->andWhere('c.idColl = :collectivite');
        ////        $qb->AddSelect('count(ba) as nbAgentArrive')->andWhere('(ba.lbDatedepacoll IS NULL AND ba.dtArriStat IS NOT NULL OR ba.blAgenarriannecoll = 1) OR (ba.dtArriStat > ba.lbDatedepacoll)');
        //$qb->AddSelect('count(ba) as nbAgent3112')->andWhere('ba.blAgenremu3112 != 0')->andWhere('(ba.dtArriStat IS NULL AND ba.lbDatedepacoll IS NULL)');

        if ($codeStatus == 'FONCTIONNAIRE') {
            //$qb->addSelect('(SELECT count(ba1) FROM ApaBundle:BilanSocialAgent ba1 LEFT JOIN ba1.refStatut s1 LEFT JOIN ba1.collectivite c1 WHERE ba1.enquete = :enquete AND c1.idColl = :collectivite AND ba1.blAgenremu3112 != 0 AND ((ba1.dtArriStat IS NULL AND ba1.lbDatedepacoll IS NULL)) AND (s1.cdStat = :statut OR s1.cdStat = :statut2)) as nbAgent3112');

            $qb->andWhere('s.cdStat = :statut OR s.cdStat = :statut2');
            $qb->setParameter('statut', 'TITU');
            $qb->setParameter('statut2', 'STAG');
        } else {
            //$qb->addSelect('(SELECT count(ba1) FROM ApaBundle:BilanSocialAgent ba1 LEFT JOIN ba1.refStatut s1 LEFT JOIN ba1.collectivite c1 WHERE ba1.enquete = :enquete AND c1.idColl = :collectivite AND ba1.blAgenremu3112 != 0 AND ((ba1.dtArriStat IS NULL AND ba1.lbDatedepacoll IS NULL)) AND s1.cdStat = :statut) as nbAgent3112');
            $qb->andWhere('s.cdStat = :statut');
            $qb->setParameter('statut', $codeStatus);
        }
        $qb->setParameter('enquete', $idEnqu);
        $qb->setParameter('collectivite', $idColl);



        try {
            $ListeAgents = $qb->getQuery()->getArrayResult();

        } catch (NoResultException $e) {
            // Pas de bilan pour cette enquete et coll
            return null;
        }

        return $ListeAgents;
    }

    public function GetAllStatuts($idEnqu, $idColl) {

        $tableau = [
            'enquete' => $idEnqu,
            'collectivite' => $idColl,
        ];

        $qb = $this->_em->createQueryBuilder();
        $qb->select('ba')
                ->from('ApaBundle:BilanSocialAgent', 'ba')
                ->where('ba.enquete = :enquete')
                ->andWhere('ba.collectivite = :collectivite');
        $qb->setParameter('enquete', $idEnqu);
        $qb->setParameter('collectivite', $idColl);





        try {
            $ListeStatut = $qb->getQuery()->getResult();
            $Statut = '1';
            foreach ($ListeStatut as $key => $value) {
                if ($value->getFgStat() == 0) {
                    $Statut = '0';
                }
            }
        } catch (NoResultException $e) {
            // Pas de bilan pour cette enquete et coll
            return null;
        }

        return $Statut;
    }

    public function GetAllAgentForImport($idEnqu, $idColl, $lbNom, $lbPren, $lbDatenais) {

        $qb = $this->_em->createQueryBuilder();

        //error_log('$idEnqu ' . json_encode($idEnqu) , 0);
        //error_log('$idColl ' . json_encode($idColl) , 0);
        //error_log('$lbNom ' . $lbNom , 0);
        //error_log('$lbPren ' . $lbPren , 0);
        //error_log('$lbDatenais ' . $lbDatenais , 0);

        $qb->select('a')
                ->from($this->_entityName, 'a')
                ->join('a.enquete', 'e')
                ->addSelect('e')
                ->join('a.collectivite', 'c')
                ->addSelect('c')
                ->where('c.idColl = :collect')
                ->setParameter('collect', $idColl)
                ->andWhere('e.idEnqu = :idEnqu')
                ->setParameter('idEnqu', $idEnqu)
                ->andWhere('a.lbDatenais = :lbDatenais')
                ->setParameter('lbDatenais', $lbDatenais)
                ->andWhere('a.lbNom = :lbNom')
                ->setParameter('lbNom', $lbNom)
                ->andWhere('a.lbPren = :lbPren')
                ->setParameter('lbPren', $lbPren)
        ;

        try {
            $agent = $qb->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }

        return $agent;
    }

    public function GetAllAgentsForImport($idEnqu, $idColl) {

        $qb = $this->_em->createQueryBuilder();
        $qb->select('a')
                ->from($this->_entityName, 'a')
                ->join('a.enquete', 'e')
                ->addSelect('e')
                ->join('a.collectivite', 'c')
                ->addSelect('c')
                ->where('c.idColl = :collect')
                ->setParameter('collect', $idColl)
                ->andWhere('e.idEnqu = :idEnqu')
                ->setParameter('idEnqu', $idEnqu)

        ;

        try {
            $agents = $qb->getQuery()->getResult();
        } catch (NoResultException $e) {
            return null;
        }

        return $agents;
    }

    public function getNoStatut($idEnqu, $idColl) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('a')
                ->from($this->_entityName, 'a')
                ->where('a.collectivite = :collectivite')
                ->setParameter('collectivite', $idColl)
                ->andWhere('a.enquete = :enquete')
                ->setParameter('enquete', $idEnqu)
                //->andWhere('a.lbStatJuriN4ds IS NOT NULL')
                ->andWhere('a.refStatut IS NULL')

        ;

        try {
            $agents = $qb->getQuery()->getResult();
        } catch (NoResultException $e) {
            return null;
        }

        return $agents;
    }
    public function countNbAgentStatus($idEnqu, $idColl, $codeStatus){
        $qb = $this->_em->createQueryBuilder();
        $qb->select('count(ba)')
            ->from('ApaBundle:BilanSocialAgent', 'ba')
            ->leftJoin('ba.refStatut', 's', 's.idStat = ba.idStat')
            ->where('ba.enquete = :enquete')
            ->andWhere('ba.collectivite = :collectivite');
        if($codeStatus ==null){
            $qb->andWhere('ba.refStatut IS NULL');
        } else if ($codeStatus == 'FONCTIONNAIRE') {
            $qb->andWhere('s.cdStat = :statut OR s.cdStat = :statut2');
            $qb->setParameter('statut', 'TITU');
            $qb->setParameter('statut2', 'STAG');
        } else {
            $qb->andWhere('s.cdStat = :statut');
            $qb->setParameter('statut', $codeStatus);
        }
        $qb->setParameter('enquete', $idEnqu);
        $qb->setParameter('collectivite', $idColl);
        $nb_agent = 0;
        try {
            $query = $qb->getQuery();
            $nb_agent = $query->getSingleScalarResult();
        } catch (NoResultException $e) {
            // Pas de bilan pour cette enquete et coll
            return false;
        } catch (\Exception $e){
            dump($e);
            return false;
        }
        return $nb_agent;
    }
   public function CountNbAgent3112($idEnqu, $idColl, $codeStatus){

     $qb = $this->_em->createQueryBuilder();
        $qb->select('count(ba) as nbAgent3112')
                ->from('ApaBundle:BilanSocialAgent', 'ba')
                ->leftJoin('ba.refStatut', 's', 's.idStat = ba.idStat')
                ->leftJoin('ba.collectivite', 'c', 'c.idColl = ba.idColl')
                ->where('ba.enquete = :enquete')
                ->andWhere('c.idColl = :collectivite');
                //->andWhere('ba.blAgenremu3112 != 0 OR ba.blAgenremu3112 IS NOT NULL')


        if ($codeStatus == 'FONCTIONNAIRE') {
            $qb->andWhere('(ba.blAgenremu3112 = 1)');
            $qb->andWhere('s.cdStat = :statut OR s.cdStat = :statut2');
            $qb->setParameter('statut', 'TITU');
            $qb->setParameter('statut2', 'STAG');
        } else {
            $qb->andWhere('(ba.blAgenremu3112 = 1)');
            $qb->andWhere('s.cdStat = :statut');
            $qb->setParameter('statut', $codeStatus);
        }
        $qb->setParameter('enquete', $idEnqu);
        $qb->setParameter('collectivite', $idColl);



        try {
            //dump($qb->getQuery());
            //exit();
            $nbAgent3112 = $qb->getQuery()->getSingleResult();

        } catch (NoResultException $e) {
            // Pas de bilan pour cette enquete et coll
            return null;
        }

        return $nbAgent3112;
    }
   public function CountNbAgentValide($idEnqu, $idColl, $codeStatus){

     $qb = $this->_em->createQueryBuilder();
        $qb->select('count(ba) as nbAgentValide')
                ->from('ApaBundle:BilanSocialAgent', 'ba')
                ->leftJoin('ba.refStatut', 's', 's.idStat = ba.idStat')
                ->leftJoin('ba.collectivite', 'c', 'c.idColl = ba.idColl')
                ->where('ba.enquete = :enquete')
                ->andWhere('c.idColl = :collectivite')
                ->andWhere('ba.fgStat = 1');

        if ($codeStatus == 'FONCTIONNAIRE') {
            $qb->andWhere('s.cdStat = :statut OR s.cdStat = :statut2');
            $qb->setParameter('statut', 'TITU');
            $qb->setParameter('statut2', 'STAG');
        } else {
            $qb->andWhere('s.cdStat = :statut');
            $qb->setParameter('statut', $codeStatus);
        }
        $qb->setParameter('enquete', $idEnqu);
        $qb->setParameter('collectivite', $idColl);



        try {
            $nbAgentValide = $qb->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            // Pas de bilan pour cette enquete et coll
            return null;
        }

        return $nbAgentValide;
    }
   public function CountNbAgentNonValide($idEnqu, $idColl, $codeStatus){

     $qb = $this->_em->createQueryBuilder();
        $qb->select('count(ba) as nbAgentNonValide')
                ->from('ApaBundle:BilanSocialAgent', 'ba')
                ->leftJoin('ba.refStatut', 's', 's.idStat = ba.idStat')
                ->leftJoin('ba.collectivite', 'c', 'c.idColl = ba.idColl')
                ->where('ba.enquete = :enquete')
                ->andWhere('c.idColl = :collectivite')
                ->andWhere('ba.fgStat = 0');

        if ($codeStatus == 'FONCTIONNAIRE') {
            $qb->andWhere('s.cdStat = :statut OR s.cdStat = :statut2');
            $qb->setParameter('statut', 'TITU');
            $qb->setParameter('statut2', 'STAG');
        } else {
            $qb->andWhere('s.cdStat = :statut');
            $qb->setParameter('statut', $codeStatus);
        }
        $qb->setParameter('enquete', $idEnqu);
        $qb->setParameter('collectivite', $idColl);



        try {
            $nbAgentNonValide = $qb->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            // Pas de bilan pour cette enquete et coll
            return null;
        }

        return $nbAgentNonValide;
    }
    public function CountNbAgentDepart($idEnqu, $idColl, $codeStatus){

        // en changeant une condition ici veuillez reporter votre modification dans le fichier APA.js pour les cohérences des informations affichées
        $qb = $this->_em->createQueryBuilder();
        $qb->select('count(ba) as nbAgentDepart')
                ->from('ApaBundle:BilanSocialAgent', 'ba')
                ->leftJoin('ba.refStatut', 's', 's.idStat = ba.idStat')
                ->leftJoin('ba.collectivite', 'c', 'c.idColl = ba.idColl')
                ->where('ba.enquete = :enquete')
                ->andWhere('c.idColl = :collectivite')
                ->andWhere('ba.blAgenremu3112 = 0');
        if ($codeStatus == 'FONCTIONNAIRE') {
            $qb->andWhere('s.cdStat = :statut OR s.cdStat = :statut2');
            $qb->setParameter('statut', 'TITU');
            $qb->setParameter('statut2', 'STAG');
        } else {
            $qb->andWhere('s.cdStat = :statut');
            $qb->setParameter('statut', $codeStatus);
        }
        $qb->setParameter('enquete', $idEnqu);
        $qb->setParameter('collectivite', $idColl);



        try {
            $nbAgentNonValide = $qb->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            // Pas de bilan pour cette enquete et coll
            return null;
        }

        return $nbAgentNonValide;
    }
    public function CountNbAgentArrive($idEnqu, $idColl, $codeStatus){
        // en changeant une condition ici veuillez reporter votre modification dans le fichier APA.js pour les cohérences des informations affichées
        $qb = $this->_em->createQueryBuilder();
        $qb->select('count(ba) as nbAgentArrive')
                ->from('ApaBundle:BilanSocialAgent', 'ba')
                ->leftJoin('ba.refStatut', 's', 's.idStat = ba.idStat')
                ->leftJoin('ba.collectivite', 'c', 'c.idColl = ba.idColl')
                ->where('ba.enquete = :enquete')
                ->andWhere('c.idColl = :collectivite');
        if ($codeStatus == 'FONCTIONNAIRE') {
            $qb->andWhere('ba.blAgenarriannecoll = 1');
        } else {
            $qb->andWhere('ba.blAgenarriannecoll = 1');
        }

        if ($codeStatus == 'FONCTIONNAIRE') {
            $qb->andWhere('s.cdStat = :statut OR s.cdStat = :statut2');
            $qb->setParameter('statut', 'TITU');
            $qb->setParameter('statut2', 'STAG');
        } else {
            $qb->andWhere('s.cdStat = :statut');
            $qb->setParameter('statut', $codeStatus);
        }
        $qb->setParameter('enquete', $idEnqu);
        $qb->setParameter('collectivite', $idColl);



        try {
            $nbAgentNonValide = $qb->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            // Pas de bilan pour cette enquete et coll
            return null;
        }

        return $nbAgentNonValide;
    }

    public function isOwnedByColl($id_coll,$id_agent){
        $is_owned = false;
        $qb = $this->_em->createQueryBuilder();
        $qb->select('count(ba) as isOwned')
            ->from('ApaBundle:BilanSocialAgent', 'ba')
            ->where('ba.idBilasociagen = :agent')
            ->andWhere('ba.collectivite = :collectivite');
        $qb->setParameter('agent', $id_agent);
        $qb->setParameter('collectivite', $id_coll);
        try {
            $query = $qb->getQuery();
            
        
            $is_owned = $query->getSingleResult();
        } catch (NoResultException $e) {
            // Pas de bilan pour cette enquete et coll
            return false;
        }
        return $is_owned['isOwned'];
    }
    
    public function findOneByActif($idColl, $idEnqu){
        
        $qb = $this->_em->createQueryBuilder();
        $qb->select('ba')
                ->from('ApaBundle:BilanSocialAgent', 'ba')
                ->where('ba.enquete = :enquete')
                ->andWhere('ba.collectivite = :collectivite');
        $qb->setParameter('enquete', $idEnqu);
        $qb->setParameter('collectivite', $idColl);
        
         try {
            $exist = $qb->getQuery()->getOneOrNullResult();
            
        } catch (NoResultException $e) {
            // Pas de bilan pour cette enquete et coll
            return false;
        }
        
        return $exist;
    }

    public function getResultsForExportCdg($idsBa, $annee) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('ba')
                ->from($this->_entityName, 'ba')
                ->join('ba.enquete', 'e')
                ->where('ba.collectivite IN (:idsBa)')
                ->andWhere('e.nmAnne = :annee')
                ->setParameter('idsBa', $idsBa)
                ->setParameter('annee', $annee);
        try {
            $result = $qb->getQuery()->getResult();
        }
        catch (NoResultException $e) {
            // Pas de enquete active consolidé pour la collectivite
            $result = null;
        }

        return $result;
    }

    public function getResultsForExport($idsBa) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('ba')
                ->from($this->_entityName, 'ba')
                ->where('ba.collectivite IN (:idsBa)')
                ->setParameter('idsBa', $idsBa);
        try {
            $result = $qb->getQuery()->getResult();
        }
        catch (NoResultException $e) {
            // Pas de enquete active consolidé pour la collectivite
            $result = null;
        }

        return $result;
    }
    public function getNextAgent($idEnqu, $idColl, $codeStatus=null, $current_offset=0){
        if($current_offset>=0){
            return $this->getOneAgent($idEnqu, $idColl, $codeStatus, $current_offset+1);
        }else{
            return false;
        }
        
    }
    public function getPrevAgent($idEnqu, $idColl, $codeStatus=null, $current_offset=0){
        if($current_offset>=1){
            return $this->getOneAgent($idEnqu, $idColl, $codeStatus, $current_offset-1);
        }else{
            return false;
        }
        
    }
    public function getOneAgent($idEnqu, $idColl, $codeStatus=null, $offset=0){
        $qb = $this->_em->createQueryBuilder();
        $qb->select('ba')
            ->from('ApaBundle:BilanSocialAgent', 'ba')
            ->leftJoin('ba.refStatut', 's', 's.idStat = ba.idStat')
            ->where('ba.enquete = :enquete')
            ->andWhere('ba.collectivite = :collectivite')
            ->setFirstResult( $offset )
            ->setMaxResults(1);
        if($codeStatus ==null){
            $qb->andWhere('ba.refStatut IS NULL');
        } else if ($codeStatus == 'FONCTIONNAIRE') {
            $qb->andWhere('s.cdStat = :statut OR s.cdStat = :statut2');
            $qb->setParameter('statut', 'TITU');
            $qb->setParameter('statut2', 'STAG');
        } else {
            $qb->andWhere('s.cdStat = :statut');
            $qb->setParameter('statut', $codeStatus);
        }
        $qb->setParameter('enquete', $idEnqu);
        $qb->setParameter('collectivite', $idColl);
        try {
            $query = $qb->getQuery();
            $agent = $query->getSingleResult();
        } catch (NoResultException $e) {
            // Pas de bilan pour cette enquete et coll
            return false;
        } catch (\Exception $e){
            dump($e);
            return false;
        }
        return $agent;
    }

    public function getOneByNameAndBirthday($idColl, $lbNom, $lbPrenom, $dtNaissance) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('ba')
                ->from('ApaBundle:BilanSocialAgent', 'ba')
                ->where('ba.collectivite = :idCollectivite')
                ->andWhere('ba.lbNom = :lbNom')
                ->andWhere('ba.lbPren = :lbPrenom')
                ->andWhere('ba.lbDatenais = :dtNaissance')
                ->setParameter('idCollectivite', $idColl)
                ->setParameter('lbNom', $lbNom)
                ->setParameter('lbPrenom', $lbPrenom)
                ->setParameter('dtNaissance', $dtNaissance)
                ->orderBy('ba.idBilasociagen', 'DESC')
                ->setMaxResults(1);
        try {
            $query = $qb->getQuery();
            $agent = $query->getOneOrNullResult();
        }
        catch (Exception $ex) {
            return $ex;
        }

        return $agent;
    }

}

<?php


namespace Bilan_Social\Bundle\ConsoBundle\Entity;


class Ind6143
{
    /**
     * @var integer
     */
    private $id6143;

    private $bilanSocialConsolide;

    private $refSanctionDisciplinaire;

    private $firstGroupe1;
    private $firstGroupe2;
    private $firstGroupe3;
    private $firstGroupe4;
    private $firstGroupe5;
    private $firstGroupe6;
    private $groupe;

    /**
     * @var integer
     */
    private $r61431;
    /**
     * @var integer
     */
    private $r61432;



    /**
     * @var \DateTime
     */
    private $dtCrea;

    /**
     * @var string
     */
    private $cdUtilcrea;

    /**
     * @var \DateTime
     */
    private $dtModi;

    /**
     * @var string
     */
    private $cdUtilmodi;


    function getId6143() {
        return $this->id6143;
    }

    function getBilanSocialConsolide() {
        return $this->bilanSocialConsolide;
    }

    function getR61431(int $ifNull = null) {
        return $this->r61431 ?? $ifNull;
    }

    function getR61432(int $ifNull = null) {
        return $this->r61432 ?? $ifNull;
    }


    function getDtCrea(): \DateTime {
        return $this->dtCrea;
    }

    function getCdUtilcrea() {
        return $this->cdUtilcrea;
    }

    function getDtModi(): \DateTime {
        return $this->dtModi;
    }

    function getCdUtilmodi() {
        return $this->cdUtilmodi;
    }

    function setId6143($id6143) {
        $this->id6143 = $id6143;
    }

    function setBilanSocialConsolide($bilanSocialConsolide) {
        $this->bilanSocialConsolide = $bilanSocialConsolide;
    }

    function setR61431($r61431) {
        $this->r61431 = $r61431;
    }

    function setR61432($r61432) {
        $this->r61432 = $r61432;
    }


    function setDtCrea(\DateTime $dtCrea) {
        $this->dtCrea = $dtCrea;
    }

    function setCdUtilcrea($cdUtilcrea) {
        $this->cdUtilcrea = $cdUtilcrea;
    }

    function setDtModi(\DateTime $dtModi) {
        $this->dtModi = $dtModi;
    }

    function setCdUtilmodi($cdUtilmodi) {
        $this->cdUtilmodi = $cdUtilmodi;
    }

    function getRefSanctionDisciplinaire() {
        return $this->refSanctionDisciplinaire;
    }

    function setRefSanctionDisciplinaire($refSanctionDisciplinaire) {
        $this->refSanctionDisciplinaire = $refSanctionDisciplinaire;
    }

    function getFirstGroupe1() {
        return $this->firstGroupe1;
    }

    function getFirstGroupe2() {
        return $this->firstGroupe2;
    }

    function getFirstGroupe3() {
        return $this->firstGroupe3;
    }

    function getFirstGroupe4() {
        return $this->firstGroupe4;
    }

    function getFirstGroupe5() {
        return $this->firstGroupe5;
    }

    function getFirstGroupe6() {
        return $this->firstGroupe6;
    }

    function getGroupe() {
        return $this->groupe;
    }

    function setFirstGroupe1($firstGroupe1) {
        $this->firstGroupe1 = $firstGroupe1;
    }

    function setFirstGroupe2($firstGroupe2) {
        $this->firstGroupe2 = $firstGroupe2;
    }

    function setFirstGroupe3($firstGroupe3) {
        $this->firstGroupe3 = $firstGroupe3;
    }

    function setFirstGroupe4($firstGroupe4) {
        $this->firstGroupe4 = $firstGroupe4;
    }

    function setFirstGroupe5($firstGroupe5) {
        $this->firstGroupe5 = $firstGroupe5;
    }

    function setFirstGroupe6($firstGroupe6) {
        $this->firstGroupe6 = $firstGroupe6;
    }

    function setGroupe($groupe) {
        $this->groupe = $groupe;
    }

}

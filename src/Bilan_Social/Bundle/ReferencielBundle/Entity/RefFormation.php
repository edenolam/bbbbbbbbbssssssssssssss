<?php

namespace Bilan_Social\Bundle\ReferencielBundle\Entity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * RefFormation
 * @UniqueEntity(
 *      fields="cdForm",
 *      errorPath="cdForm",
 *      message="Ce code est déjà existant."
 * )
 */
class RefFormation extends RefAbstractEntity{

    /**
     * @var string
     */
    protected $cdForm;

    /**
     * @var string
     */
    protected $lbForm;

    /**
     * @var boolean
     */
    protected $blPrev;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var string
     */
    protected $cdUtilcrea;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var string
     */
    protected $cdUtilmodi;

    /**
     * @var integer
     */
    protected $idForm;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $bilanSocialAgents;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $FormationAgents;

    protected $cdDGCL;

    /**
     * Constructor
     */
    public function __construct() {
        $this->bilanSocialAgents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->FormationAgents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set cdForm
     *
     * @param string $cdForm
     *
     * @return RefFormation
     */
    public function setCdForm($cdForm) {
        $this->cdForm = $cdForm;

        return $this;
    }

    /**
     * Get cdForm
     *
     * @return string
     */
    public function getCdForm() {
        return $this->cdForm;
    }

    /**
     * Set lbForm
     *
     * @param string $lbForm
     *
     * @return RefFormation
     */
    public function setLbForm($lbForm) {
        $this->lbForm = $lbForm;

        return $this;
    }

    /**
     * Get lbForm
     *
     * @return string
     */
    public function getLbForm() {
        return $this->lbForm;
    }

    /**
     * Set blPrev
     *
     * @param boolean $blPrev
     *
     * @return RefFormation
     */
    public function setBlPrev($blPrev) {
        $this->blPrev = $blPrev;

        return $this;
    }

    /**
     * Get blPrev
     *
     * @return boolean
     */
    public function getBlPrev() {
        return $this->blPrev;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return RefFormation
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set cdUtilcrea
     *
     * @param string $cdUtilcrea
     *
     * @return RefFormation
     */
    public function setCdUtilcrea($cdUtilcrea) {
        $this->cdUtilcrea = $cdUtilcrea;

        return $this;
    }

    /**
     * Get cdUtilcrea
     *
     * @return string
     */
    public function getCdUtilcrea() {
        return $this->cdUtilcrea;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return RefFormation
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * Set cdUtilmodi
     *
     * @param string $cdUtilmodi
     *
     * @return RefFormation
     */
    public function setCdUtilmodi($cdUtilmodi) {
        $this->cdUtilmodi = $cdUtilmodi;

        return $this;
    }

    /**
     * Get cdUtilmodi
     *
     * @return string
     */
    public function getCdUtilmodi() {
        return $this->cdUtilmodi;
    }

    /**
     * Get idForm
     *
     * @return integer
     */
    public function getIdForm() {
        return $this->idForm;
    }

    /**
     * Add bilanSocialAgent
     *
     * @param \Bilan_Social\Bundle\ApaBundle\Entity\BilanSocialAgent $bilanSocialAgent
     *
     * @return RefFormation
     */
    public function addBilanSocialAgent(\Bilan_Social\Bundle\ApaBundle\Entity\BilanSocialAgent $bilanSocialAgent) {
        $this->bilanSocialAgents[] = $bilanSocialAgent;

        return $this;
    }

    /**
     * Remove bilanSocialAgent
     *
     * @param \Bilan_Social\Bundle\ApaBundle\Entity\BilanSocialAgent $bilanSocialAgent
     */
    public function removeBilanSocialAgent(\Bilan_Social\Bundle\ApaBundle\Entity\BilanSocialAgent $bilanSocialAgent) {
        $this->bilanSocialAgents->removeElement($bilanSocialAgent);
    }

    /**
     * Get bilanSocialAgents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBilanSocialAgents() {
        return $this->bilanSocialAgents;
    }

    /**
     * Add FormationAgent
     *
     * @param \Bilan_Social\Bundle\ApaBundle\Entity\FormationAgent $FormationAgents
     *
     * @return RefFormation
     */
    public function addFormationAgent(\Bilan_Social\Bundle\ApaBundle\Entity\FormationAgent $FormationAgents) {
        $this->FormationAgents[] = $FormationAgents;

        return $this;
    }

    /**
     * Remove FormationAgent
     *
     * @param \Bilan_Social\Bundle\ApaBundle\Entity\FormationAgent $FormationAgents
     */
    public function removeFormationAgent(\Bilan_Social\Bundle\ApaBundle\Entity\FormationAgent $FormationAgents) {
        $this->FormationAgents->removeElement($FormationAgents);
    }

    /**
     * Get FormationAgents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormationAgents() {
        return $this->FormationAgents;
    }

    public function setUpdateDateValue() {
        $this->setUpdatedAt(new \Datetime());
    }

    public function setCreatedAtValue() {
        $this->setCreatedAt(new \DateTime());
    }

    function getCdDGCL() {
        return $this->cdDGCL;
    }

    function setCdDGCL($cdDGCL) {
        $this->cdDGCL = $cdDGCL;
    }



}

<?php

namespace BOUTIQUE\Entity;



class membre
{
    private $id_commande;
    private $id_membre;
    private $montant;
    private $date_enregistrement;
    private $etat;


    public function getId_commande(){
        return $this -> id_commande;
    }

    public function setId_commande( ($id_co){
    $this -> id_commande  = $id_co ;
    }

    public function getId_membre(){
        return $this -> id_membre;
    }

    public function setId_membre( ($id_m){
    $this -> id_membre  = $id_m ;
    }

    public function getMontant(){
        return $this -> montant;
    }

    public function setMontant( ($montant){
    $this -> montant  = $montant ;
    }

    public function getdate_Enregistrement(){
        return $this -> date_enregistrement;
    }

    public function setdate_Enregistrement( ($date_enr){
    $this -> date_enregistrement  = $date_enr ;
    }

    public function getEtat(){
        return $this -> etat;
    }

    public function setEtat( ($etat){
    $this -> etat  = $etat ;
    }


}

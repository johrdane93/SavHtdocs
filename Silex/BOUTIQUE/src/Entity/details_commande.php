<?php

namespace BOUTIQUE\Entity;



class membre
{
    private $id_details_commande;
    private $id_commande;
    private $id_produit;
    private $quantite;
    private $prix;



    public function getId_details_commande(){
        return $this -> id_details_commande;
    }

    public function setId_details_commande( ($id_det){
    $this -> id_details_commande  = $id_det ;
    }

    public function getId_commande(){
        return $this -> id_commande;
    }

    public function setId_commande( ($id_co){
    $this -> id_commande  = $id_co ;
    }


    public function getId_produit(){
        return $this -> id_produit;
    }

    public function setId_produit( ($id_pro){
    $this -> id_produit  = $id_pro ;

    public function getQuantite(){
        return $this ->quantite ;
    }

    public function setQuantite( ($quant){
    $this -> quantite  = $quant ;
    }

    public function getPrix(){
        return $this -> prix;
    }

    public function setPrix( ($prix){
    $this -> prix  = $prix ;
    }


























}

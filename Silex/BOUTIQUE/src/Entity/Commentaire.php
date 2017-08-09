<?php
//BOUTIQUE/Entity/Commentaire.php

namespace BOUTIQUE\Entity;

class Commentaire {

  /*
    *Cle primaire de ma table commentaire
    *
    *@var interget
  */
private $id_commentaire;

/*
  *Auteur du commentaire
  *
  *@var string
*/
private $auteur;

/*
  *Contenue du commentaire
  *
  *@var string
*/
private $contenu;

/*
  *produit lie au comlmentaire (produit Assocé)
  *
  *@var BOUTIQUE/Entity/produit
*/
private $produit; // et non pas private $id_produit //Contendre un objet de la classe produit !

/*
  *contien la date du commentaire sous forme de datetime
  *
  *@var string
*/
private $date_enregistrement;


public function getDate_enregistrement() {
    return $this-> date_enregistrement;
    }
public function setDate_enregistrement($date) {
  $this -> date_enregistrement = $date ;
}


public function getProduit() {
    return $this-> produit ;
    }
public function setProduit( Produit $produit) {
  $this -> produit = $produit ;
}

public function getContenu() {
    return $this->contenu ;
    }
public function setContenu($content) {
  $this -> contenu = $content ;
}

public function getAuteur() {
    return $this->auteur ;
    }
public function setAuteur($auteur) {
  $this -> auteur = $auteur ;
}

public function getId_commentaire() {
    return $this->id_commentaire ;
    }
public function setId_commentaire($id_commentaire) {
  $this -> id_commentaire = $id_commentaire ;
}

}

<?php

namespace BOUTIQUE\Entity;

class produit
{
    private $id_produit;
    private $reference;
    private $categorie;
    private $titre;
    private $description;
    private $couleur;
    private $taille;
    private $public;
    private $photo;
    private $prix;
    private $stock;

    public function getId_produit(){
        return $this -> id_produit;
    }

public function setId_produit($id){
  $this -> id_produit = $id;
}



public function getReference(){
    return $this -> reference;
}

public function setReference($ref){
$this -> reference = $ref;
}


public function getCategorie(){
    return $this -> categories;
}

public function setCategorie($cat){
$this -> categories = $cat;
}



public function getTitre(){
    return $this -> titre ;
}

public function setTitre ($titre){
$this -> titre = $titre ;
}

public function getDescription(){
    return $this -> titre ;
}

public function setDescription ($desc){
$this -> description = $desc ;
}


public function getCouleur(){
    return $this -> couleur ;
}

public function setCouleur ($coul){
$this -> couleur = $coul;
}


public function getTaille(){
    return $this -> taille ;
}

public function setTaille($taille){
$this -> taille = $taille;
}


public function getPublic(){
    return $this -> public ;
}

public function setPublic($pub){
$this -> public = $pub ;
}


public function getPhoto(){
    return $this -> photo ;
}

public function setPhoto($pho){
$this -> photo = $pho ;
}

public function getPrix(){
    return $this -> prix ;
}

public function setPrix($prix){
$this -> prix = $prix ;
}

public function getStock(){
    return $this -> stock ;
}

public function setStock($stock){
$this -> stock = $stock ;
}



}

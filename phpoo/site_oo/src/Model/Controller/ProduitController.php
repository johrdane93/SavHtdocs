<?php


class ProduitController
{
  private $model;
  public function __construct(){
      $this -> model = new ProduitModel;
  }

  public function getModel(){
    return $this -> model ;
  }

  //Affiche tout les produit
  public function afficheALL(){
    //objectif 1 : recupere les donner dans la Bdd
    $produits = $this -> getModel() -> getALLProduits();
    $categories = $this -> getModel() -> getALLCategories();

    //objectif 2 : afficher la vue (boutique.php) :
    require __DIR__ .'/../View/haut.inc.php';
    require __DIR__ .'/../View/produit/boutique.php';
    require __DIR__ .'/../View/bas.inc.php';
  }

 // Afficher les produit par Categories
 public function afficheCategorie($Categories){

 }

//Afficher un produit
public function affiche($id){}



}
    // Ajouter Produit
    // Supprimer Produit
    // modifier produits
    // trier les produits
    //Ajouter le produit au panier (commandeController)

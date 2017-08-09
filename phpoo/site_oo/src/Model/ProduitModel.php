<?php
//phpoo\site_oo\src\Model

class produitModel{

  private $db;// conntien un objet PDO

  public function __construct(){
      $this -> db = PDOmanager::getInstance() -> getPDO();

  }
  public function getdb(){
      return $this -> db;
}

//----------------------
  // select* from produit
  public function getALLProduits(){
      $requete ="SELECT * FROM produit";
      $resultat = $this -> getDb() -> query($requete);
      $produits= $resultat  -> fetchAll(PDO::FETCH_ASSOC);
        if(!$produits){
          false;
        }else {
          return $produits;
        }
  }
  // select DISTINCT Categories from produit
  public function getALLCategories(){
    $requete ="SELECT DISTINCT Categorie FROM produit";
    $resultat = $this -> getDb() -> query($requete);
    $categories= $resultat  -> fetchAll(PDO::FETCH_ASSOC);
    if(!$categories){
      false;
    }else {
      return $categories;
    }


    //getALLCategories : camelCase
    //getALLCategories : snake_case
    //getALLCategories : steadycase
  }

  // SELECT * FROM produit WHERE categorie = xxxx
  public function getALLProduitsByCategorie ($categorie){
    $requete ="SELECT * FROM produit WHERE categories = :categories";
    $resultat = $this -> getDb() -> prepare($requete);
    $resultat -> bindParam (":categories, $categorie, PDO::PARAM_STR");
    $resultat -> execute ();

    $produits= $resultat  -> fetchAll(PDO::FETCH_ASSOC);
      if(!$produits){
        false;
      }else {
        return $produits;
      }
  }
  // SELECT * FROM produit WHERE id_produit  = xxxx
  public function getALLProduitsById($id){
    $requete ="SELECT * FROM produit WHERE id_produit = :id_produit";
    $resultat = $this -> getDb() -> prepare($requete);
    $resultat -> bindParam (":id_produit, $id, PDO::PARAM_INT");
    $resultat -> execute ();

$produit= $resultat  -> fetch(PDO::FETCH_ASSOC);
      if(!$produit){
        false;
      }else {
        return $produit;
      }
  }





}

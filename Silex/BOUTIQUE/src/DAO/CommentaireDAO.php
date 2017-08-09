<?php
//BOUTIQUE/Entity/Commentaire.php

namespace BOUTIQUE\Entity;
use Doctrin\DBAL\Connection;
use BOUTIQUE\Entity\Commentaire;


class CommentaireDAO {



private $db;

public function __construct (Connection $db){
    $this -> db = $db;
}

public function getDB(){
  return $this -> db;
}

/*
*Contiendre un objet de la class produitDAO afin d'interagire et de recuperer un objet Produit pour chaque commentaire recupere
*
*@var BOUTIQUE\DAO\ProduitDAO
*/
private $produitDao;

public function setProduitDAO(ProduitDAO $produitDao){
    $this -> produitDao = $produitDao;

 }
  public function findAllByProduit($id_produit){
    requete = "SELECT id_commentaire, auteur, contenue, date_enregistrement FROM commentaire WHERE id_produit =? ORDER BY date_enregistrement DESC";
    $resultat $this -> getDb() -> fetchAll ($requete, array ($id_produit));
    $resultat $this -> produitDao -> find($id_produit);

    $commentaires = array();
    foreach ($resultat as $value) {
      $id_commentaire $value['id_commentaire'];

      $commentaire = $this -> buildCommentaire($value);
      $commentaire -> setProduit($produit);

      $commentaires['id_commentaire'] =$commentaire;
    }
    return $commentaires;
  }

protected function buildCommentaire($info){
    $commentaires new Commentaires;

    $commentaires -> setId_commentaire($infos['id_commentaire']);
    $commentaires ->setAuteur($infos['auteur']);
    $commentaires ->setContenue($infos['contenu']);
    $commentaires ->setDate_enregistrement($infos['date_enregistrement']);
}
// Si ma requete fait un SELECT alor je ferait ceci:
if (array_key_exists('id_produit,$infos')) {
  $id_produit =$infos['id_produit'];
  $produit =$this -> produitDao -> find($id_produit);
  $commentaire -> setProduit($produit);
}
return $commentaire;
}

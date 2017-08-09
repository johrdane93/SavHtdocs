<?php

function afficheAll(){

  $pdo = new PDO('mysql:host=localhost;dbname=site','root','');
  $resultat= $pdo -> query("SELECT * FROM produit");
  $produits = $resultat -> fetchAll(PDO::FETCH_ASSOC);

  $resultat = $pdo -> query("SELECT DISTINCT categorie FROM produit");

  $categories = $resultat -> fetchAll(PDO::FETCH_ASSOC);

  $infos = array(
        "produits"=>$produits ,
        "categories"=> $categories
  );
  return $infos;
}

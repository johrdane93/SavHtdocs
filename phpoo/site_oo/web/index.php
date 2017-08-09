<?php

session_start();


require __DIR__.'/../vendor/PDOmanager.php';
require __DIR__.'/../src/Model/ProduitModel.php';
require __DIR__.'/../src/Controller/ProduitController.php';

// $pm = new ProduitModel;
//
// $produit = $pm -> getALLProduit();
// $categorie =$pm -> getALLProduitsByCategorie('pull');
// $produit =$pm -> getALLProduitsById(8);
//
// echo'<pre>'
// print_r($produits);
// echo'</pre>'

$pc = new ProduitController;
$pc -> afficheALL();

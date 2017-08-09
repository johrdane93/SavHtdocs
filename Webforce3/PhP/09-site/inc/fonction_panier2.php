<?php


function creationPanier(){
   if (!isset($_SESSION['panier'])){
      $_SESSION['panier']=array();
      $_SESSION['panier']['libelleProduit'] = array();
      $_SESSION['panier']['qteProduit'] = array();
      $_SESSION['panier']['prixProduit'] = array();
      $_SESSION['panier']['verrou'] = false;
   }
   return true;
}


function ajouterproduitDanspanier($titret,$id_produit,$quantite,$prix){
creationDuPanier();
   {
      //Si le produit existe déjà on ajoute seulement la quantité
      $positionProduit = array_search($id_produit,  $_SESSION['panier']['id_produit']);// retourne un chiffe si le produit existe qui corresponde a l'indice de celui dans le panier (0 pour le premier indice ).si le produit nest pas dans le panier arzry_search retourne false

      if ($positionProduit !== false)
      {
         $_SESSION['panier']['titre'][] = $titre ;
         $_SESSION['panier']['id_produit'][] = $ ;
         $_SESSION['panier']['quantite'][] = $ ;
         $_SESSION['panier']['prix'][] = $ ;//crochets videsn pour ajouter a l'indice numerique suivant
      }
      else
      {
        $_SESSION['panier']['quantit'][$position_Produit] += $quantite ;

         //Sinon on ajoute le produit
         array_push( $_SESSION['panier']['libelleProduit'],$libelleProduit);
         array_push( $_SESSION['panier']['qteProduit'],$qteProduit);
         array_push( $_SESSION['panier']['prixProduit'],$prixProduit);
      }
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}





 ?>

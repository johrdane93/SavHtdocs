<?php

//******************************************************************|
//-----------------1. Création du paniers--------------------|
//*****************************************************************|

//Nous allons commencer avec une fonction creationPanier():

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
/*Quelques explications :

Dans un premier temps on regarde si le panier existe, sinon on le crée
On retourne true pour des raisons de pratique lors des tests 'if'
La variable 'verrou' me permet de verrouiller toute action sur le panier, le verrou est à activer lorsque vous passez votre panier en paiement (non couvert dans cet article) */

//******************************************************************|
//-----------------2. Ajout d'un article--------------------|
//*****************************************************************|

//Nous allons ajouter une fonction ajouterArticle() (toujours dans le fichier fonctions-panier.php, n'ayez crainte je fournis le code complet en fin d'article)

function ajouterArticle($libelleProduit,$qteProduit,$prixProduit){

   //Si le panier existe
   if (creationPanier() && !isVerrouille())
   {
      //Si le produit existe déjà on ajoute seulement la quantité
      $positionProduit = array_search($libelleProduit,  $_SESSION['panier']['libelleProduit']);

      if ($positionProduit !== false)
      {
         $_SESSION['panier']['qteProduit'][$positionProduit] += $qteProduit ;
      }
      else
      {
         //Sinon on ajoute le produit
         array_push( $_SESSION['panier']['libelleProduit'],$libelleProduit);
         array_push( $_SESSION['panier']['qteProduit'],$qteProduit);
         array_push( $_SESSION['panier']['prixProduit'],$prixProduit);
      }
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}

/*
Quelques explications :

 -On vérifie en premier que le panier existe via notre fonction précédente creationPanier() et on vérifie que le panier n'est pas verrouillé.
-On regarde si l'article existe déjà : si oui on augmente sa quantité dans le paniersi non on l'ajoute.
*/

//******************************************************************|
//-----------------3. Suppression d'un article--------------------|
//*****************************************************************|

//Pour être en mesure de supprimer un article, il nous faut également une fonction, la voici :

function supprimerArticle($libelleProduit){
   //Si le panier existe
   if (creationPanier() && !isVerrouille())
   {
      //Nous allons passer par un panier temporaire
      $tmp=array();
      $tmp['libelleProduit'] = array();
      $tmp['qteProduit'] = array();
      $tmp['prixProduit'] = array();
      $tmp['verrou'] = $_SESSION['panier']['verrou'];

      for($i = 0; $i < count($_SESSION['panier']['libelleProduit']); $i++)
      {
         if ($_SESSION['panier']['libelleProduit'][$i] !== $libelleProduit)
         {
            array_push( $tmp['libelleProduit'],$_SESSION['panier']['libelleProduit'][$i]);
            array_push( $tmp['qteProduit'],$_SESSION['panier']['qteProduit'][$i]);
            array_push( $tmp['prixProduit'],$_SESSION['panier']['prixProduit'][$i]);
         }

      }
      //On remplace le panier en session par notre panier temporaire à jour
      $_SESSION['panier'] =  $tmp;
      //On efface notre panier temporaire
      unset($tmp);
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}

/*
Quelques explications :

-On vérifie en premier que le panier existe via notre fonction précédente creationPanier() (et on vérifie le verrou)

-On crée un panier "tampon" qui va être notre panier sans les éléments à supprimer

-On remplit ledit panier "tampon"

-On réaffecte notre panier via les valeurs du panier tampon que l'on supprime par la suite

Cette méthode nous permet de garder un panier sans fioritures, nous aurions pu simplement supprimer les valeurs correspondantes dans le premier panier,
ce qui aurait eu pour effet de laisser des valeurs NULL dans le panier et l'aurait rendu peu pratique à l'utilisation !*/

//******************************************************************|
//----------------4. Modifier un article----------------------|
//*****************************************************************|

/*Enfin il nous manque une fonction qui peut ne pas être mise en place mais qui ajoute un grand confort à l'utilisation du panier,
à savoir la modification de la quantité d'un article, la voici :*/

function modifierQTeArticle($libelleProduit,$qteProduit){
   //Si le panier éxiste
   if (creationPanier() && !isVerrouille())
   {
      //Si la quantité est positive on modifie sinon on supprime l'article
      if ($qteProduit > 0)
      {
         //Recharche du produit dans le panier
         $positionProduit = array_search($libelleProduit,  $_SESSION['panier']['libelleProduit']);

         if ($positionProduit !== false)
         {
            $_SESSION['panier']['qteProduit'][$positionProduit] = $qteProduit ;
         }
      }
      else
      supprimerArticle($libelleProduit);
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}

/*
Quelques explications :

-On vérifie en premier que le panier existe via notre fonction précédente creationPanier()

-Si la quantité demandée pour un produit est supérieure à 0 (et accessoirement celui ci existe mais il a peu de chance qu'on demande la modification d'un article qui n'existe pas ^^)

-on la modifie

-Si la quantité est négative ou nulle cela revient à dire que l'on supprime l'article !*/

//******************************************************************|
//------------------5. Montant du panier---------------------|
//*****************************************************************|

/*
Evidement que serait notre panier s'il ne renvoyait pas le montant global des achats ?
*/

function MontantGlobal(){
   $total=0;
   for($i = 0; $i < count($_SESSION['panier']['libelleProduit']); $i++)
   {
      $total += $_SESSION['panier']['qteProduit'][$i] * $_SESSION['panier']['prixProduit'][$i];
   }
   return $total;
}

/**/

//******************************************************************|
//-------------------6. Quelques fonctions utiles---------------------|
//*****************************************************************|
//Nous allons ajouter quelques fonctions utiles et en premier lien la fonction de vérification du verrou :


//Cette fonction vérifie seulement l'état du verrou sans affecter le panier.
function isVerrouille(){
   if (isset($_SESSION['panier']) && $_SESSION['panier']['verrou'])
   return true;
   else
   return false;
}

/*Quant à cette fonction la, elle permet de compter le nombre d'articles différends dans le panier.
Pour avoir le nombre d'article en fonction de la quantité de chacun il faudra parcourir les articles et prendre en compte chaque quantités*/

function compterArticles()
{
   if (isset($_SESSION['panier']))
   return count($_SESSION['panier']['libelleProduit']);
   else
   return 0;

}



//Et une fonction qui peut s'avérer indispensable dans toute bonne boutique : la suppression du panier.
function supprimePanier(){
   unset($_SESSION['panier']);
}

<h1>couleur</h1>

<?php
//------------------------
//Exercice :
/*-------------------------------------------------------
                    Exercice
Dans ListeFruit.php : créer 3 liens banane , kiwi , et cerise

passer le fruit dans l'url en get a la page couleur.php.

Dans couleur .php : recupérer le fruit dans l'url et afficher sa ciouleur avec une phrase du type "la couleur des banane et jaune".

penser a se premunire des tentative d'accés direct à la page couleur.php par nue condition.


------------------------------------------------------*/

echo '<pre>' ; var_dump($_GET); echo '</pre>' ;

if(isset($_GET['article'])){

  echo '<p>article:'.$_GET['couleur']. ' </p>';
}else {
  echo '<p>Ce produit n\'existe pas</p>';
}











































 ?>

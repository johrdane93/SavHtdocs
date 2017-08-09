<h1>page detail des arcticle</h1>
<?php
//----------------------
//le superglobale $_GET
//------------------------
//$_GET represente Lurl : il sagit d'une superglobale et comme toute les super globale il sagit d'un array.
//donc supergloibale signifie que cette variable et disponiblr dans tout les contexte du script ;y colprit dans les fonctions , etv qu'il n'est pas necessaire de faire globale $_GET
// les information transite dans L'url de la maniére suivante:
// ?indice=valeur&indice2+valeur2
// la superglobale $_GET transforme ces informations passee dans k'url en cette array : $_GET = array('indice'=> 'valeur','indice2'=>'Valeur2')


echo '<pre>' ; var_dump($_GET); echo '</pre>' ;
// on met une condition qui verifie qu'in a bien Les infos dans l'url:
if(isset($_GET['article'])&& isset($_GET['couleur'])&&isset($_GET['prix'])){

  echo '<p>article:'.$_GET['article']. ' </p>';
  echo '<p>Couleur:'.$_GET['couleur']. ' </p>';
  echo '<p>Prix:'.$_GET['prix']. ' </p>';
}else {
  echo '<p>Ce produit n\'existe pas</p>';
}


























































 ?>

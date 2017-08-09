<?php
require_once 'inc/init.inc.php';
//******************Traitement*********************************
// redirection si visiteur non connecté :
if(!internauteEstConnecte()){
  header('location:connexion.php');
  exit();
}
//prepare le profil a afficher :
//debug($_SESSION);

$contenu .= '<h1>Bonjour'.$_SESSION['membre']['pseudo'].'</h1>';
$contenu .= '<p>votre email'.$_SESSION['membre']['email'].'</p>';
$contenu .= '<p>votre adresse'.$_SESSION['membre']['adresse'].'</p>';
$contenu .= '<p>votre code postale '.$_SESSION['membre']['code_postal'].'</p>';
$contenu .= '<p> votre ville '.$_SESSION['membre']['ville'].'</p>';




//******************************Affichage************************
require_once 'inc\haut.inc.php';
echo $contenu;
require_once 'inc\bas.inc.php';

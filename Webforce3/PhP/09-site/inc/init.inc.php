<?php
/*Le fichier init.inc.php sera inclis dans tout les scripts (hors les fichier .inc eux-mêmes)
pour initialiser les élément suivants :
 -connection à la bdd
 -creation ou ouverture de Session
 -definir le chemin du site
 -rt inclure le fichier fonction.inc.php
*/

//Connection à la bdd
  $pdo = new PDO('mysql:host=localhost;dbname=site','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

//Session :
session_start(); // Cree ou ouvre une session sur le serveur.

//Definition du chemin du site:
define('RACINE_SITE','/Webforce3/PhP/09-site/');// indique le dossier dans le quel ce trouve les source du site 'localhost'.


//Variable d'affichage de contenue:
$contenu ='';
$contenu_gauche ='';
$contenu_droite ='';


//inclusion des fonction
require_once('fonction.inc.php'); // on inclut ce fichier ici , ainsi il sera automatiquement inclus dans tout les script du site

?>

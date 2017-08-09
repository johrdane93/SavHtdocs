
<?php


// Connexion à la BDD :
$pdo = new PDO('mysql:host=localhost;dbname=chat_ajax', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

// Session :
session_start();

// Définition du chemin du site
define('RACINE_SITE', '/chat_ajax'); // indique le dossier dans lequel se trouve les sources du site


// inclusion des fonctions
require_once('fonction.inc.php');

$contenu = "";

<?php





try {
  $bdd = new PDO('mysql:host=localhost;dbname=annonceo;charset=utf8','root','');
} catch (PDOException $e) {
  echo 'Connexion échouée : ' . $e;
}

define('URL', 'http://localhost/projet-annonceo-2/annonceo/', false);

session_start();

require_once('fonction.inc.php');

 ?>

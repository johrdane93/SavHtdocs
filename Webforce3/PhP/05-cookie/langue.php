<?php
//-------------------------------------
//        COOKIE
//--------------------------------------
 /*Definition
 un cookie et un petit fichier de'( 4ko maxi )'deposer par le serveur du site  dans le naviguateur de l'internaute et qui peut contenire des information.
 Les cookie sont automatiquement renvoyés au serveur web par le naviguateur lorsque l'internaute navigue dans les page concernnees par les cookies

PHP permet de recuperer tre facilement  les donner contenue dans un cokkie ses information sont recuperees dans la superglobale $_COOKIE.

precaution a prendre avec lesz cookie étant sauvgarde sur le poste de l'internaute , un cookie peur être potentiellement détourné ou volé . on n'y stocke donc pas par precaution des donnees sensibles (motde passe, referance bancaires, panier d'achat)


//application pratique: nous allon stocker la langue choisie par l'internaute dans un cookie afin de lui afficher le site dans cette langue à chaque visite :

 */
//on determine une variable $langue :
if(isset($_GET['langue'])){
  //si on a clisué sur un des lien
  $langue = $_GET['langue'];
}elseif (isset($_COOKIE['langue'])) {
  // si on a recu un cokkie appele "langue":
  $langue = $_COOKIE['langue'];
}else {
  // par default , la langue et le francais:
  $langue = 'fr';
}
//creation du cooki:
$un_an=365*24*3600; // variable que represente un an exprime en seconde

setCookie ('langue',$langue,time() + $un_an);//envoie un cookie dans le naviguateur de l'internaute : setCookie ('nom', 'valeur',date expiration en timestamp')
// pour rendre un COOKIE inactif , on lui met une date passée ou a 0 , car il n'existe pas de fonction pour supprimer un cookie

//affichage de la langue
echo'Langue';
switch ($langue) {
  case 'fr':echo ' francais';break;
  case 'it':echo ' italilen';break;
  case 'es':echo ' espagnol';break;
  case 'en':echo ' Anglais';break;
  default:echo 'francais';

}


//---------------- html----------

?>
<h1>Votre langue</h1>
<ul>
  <li><a href="?langue=fr">Français</a></li>
  <li><a href="?langue=es">Espagnol</a></li>
  <li><a href="?langue=it">Italien</a></li>
  <li><a href="?langue=en">Anglais</a></li>
</ul>

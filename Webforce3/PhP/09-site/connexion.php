<?php
require_once 'inc/init.inc.php';
//******************Traitement*********************************
// deconnection de l'internaute a sa demande :
if (isset($_GET['action']) && $_GET['action'] == 'deconnexion') {
session_destroy();// rappel : cette instruction est executee a la fin du script
}

// Internaute est deja conncté :
if(internauteEstConnecte()){
  // on le renvoie vers la page de profil :
  header('location:profil.php');// on renvoie une redirection vers la page profil
  exit();// on quitte le script
}
//Traitement du formulaire
if($_POST){
  // si le formulaire et soumis :
  if(strlen($_POST['pseudo']) < 4 || strlen($_POST['pseudo']) >20)
    $contenu .= '<div class="bg-danger">le pseudo et requis</div>';

  if(strlen($_POST['mdp']) < 4 || strlen($_POST['mdp']) >20)
    $contenu .= '<div class="bg-danger">le mdp et requis</div>';
    if (empty($contenu)) {
 //si $contenu et vide c'est qu'il n'y a pas d'Erreur :
$mdp = md5($_POST['mdp']); //on crypte le mdp pour le comprarer à celui de la bdd

$resultat = executeRequete("SELECT * FROM membre WHERE mdp = :mdp AND pseudo = :pseudo" ,array(':mdp' =>$mdp, 'pseudo'=> $_POST['pseudo']));

if($resultat->rowCount() !=0){// si il y a une ligne dans le resultat de la requete , alors le membre est bien inscrit avec les bon login et mdp
$membre = $resultat->fetch(PDO::FETCH_ASSOC);// pas de while car il n'y a qu'un seul membre possedant les login/mdp correctes

//debug($membre);
$_SESSION['membre'] = $membre; // nous creeon une session "membre "evec les element provennant e la bdd

//debug($_SESSION);
header('location:profil.php');// le membre etant connecter on lenvoie ver son profi
exit();



//----------

}else {
$contenu .=  '<div class="bg-danger">Erreur sur les identifiant</div>';
    }
  }
}







//******************************Affichage************************
require_once 'inc\haut.inc.php';
echo $contenu
?>
<h3>veuillez renseignez vos identifiant pour vous connecter</h3>
<form  action="" method="post">
<label for="pseudo">pseudo</label><br>
<input type="text" name="pseudo" id="pseudo"><br><br>

<label for="mdp">mot de passe</label><br><br>
<input type="password" name="mdp" id="mdp">

<input type="submit" name="se connecter" class="btn">
</form>
<?php
require_once 'inc/bas.inc.php';

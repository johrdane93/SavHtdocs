<?php
require_once("inc/init.inc.php");

$content = '';

if(isset($_GET['action']) && $_GET['action'] == 'deconnexion')
{
	unset($_SESSION['membre']);
}
if(internauteEstConnecte())
{
	header('location:profil.php');
	exit();
}

if($_POST)
{
	$r = $bdd->query("SELECT * FROM membre WHERE pseudo ='$_POST[pseudo]'");// nous selectionnons en BDD les informations de l'internaute qui tente de saisr un pseudo
	if($r->rowCount() >= 1) // nous comptons le nombre de résultats de la requete select, si il y a au moins 1 resultat, c'est qu'un pseudo de la BDD correspond bien au pseudo du formulaire
	{
		$membre = $r->fetch(PDO::FETCH_ASSOC); // on transforme le resultat en tableau ARRAY, nous avons donc dans ce tableau toute les infos de l'internaute qui a saise le bon pseudo


		if($_POST['mdp'] == $membre['mdp']) // on compare le mot de passe saisie dans le formulaire avec celui selectionné en BDD
		{ // nous rentrons ici seulement si les mots de passe correspondent

			$_SESSION['membre']['id_membre'] = $membre['id_membre']; // on crée un espace à l'intérieur du fichier session et enregistrons les informations lié à cet internaute
			$_SESSION['membre']['pseudo'] = $membre['pseudo'];
			$_SESSION['membre']['nom'] = $membre['nom'];
			$_SESSION['membre']['prenom'] = $membre['prenom'];
			$_SESSION['membre']['telephone'] = $membre['telephone'];
			$_SESSION['membre']['email'] = $membre['email'];
			$_SESSION['membre']['civilite'] = $membre['civilite'];
			$_SESSION['membre']['statut'] = $membre['statut'];
			$_SESSION['membre']['date_enregistrement'] = $membre['date_enregistrement'];
			//debug($_SESSION);

			header("location:profil.php"); // une fois connécté, nous redirigeons l'internaute vers sa page profil

		}
		else
		{
			$content .= '<div class="erreur">Mot de passe incorrect!</div>';
		}
	}
	else
	{
		$content .= '<div class="erreur">Ce pseudo n\'est pas connu !</div>';
	}
}

require_once("inc/haut.inc.php");
echo $content;

?>

<form method="post" action="">

	<div class="form-group" style="width:25%;">
	<label for="pseudo">Pseudo</label>
	<input type="text" id="pseudo" name="pseudo" class="form-control">
	</div>

	<div class="form-group" style="width:25%;">
	<label for="mdp">Mot de passe</label>
	<input type="text" id="mdp" name="mdp" class="form-control">
	</div>

	<input type="submit" value="connexion" class="btn btn-success" >
</form>

<?php
require_once("inc/bas.inc.php");
?>

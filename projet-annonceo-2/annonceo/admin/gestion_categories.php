<?php
require_once("../inc/init.inc.php");


$content = '';
/***************  SECURITE ADMIN  *********************************************/

if(!internauteEstConnecteEtEstAdmin())
{
	header("location:../connexion.php");
	exit(); // interrompt le script
}
/*******************************************************************************/

if($_POST)
{
	if(strlen($_POST['titre']) < 3 || strlen($_POST['titre']) > 25)
		{
			$content .= '<div class="erreur">Le titre doit contenir entre entre 3 et 25 caractères</div>';
		}

	if(strlen($_POST['motscles']) < 3 || strlen($_POST['motscles']) > 75)
		{
			$content .= '<div class="erreur">Les mots clés doivent contenir entre entre 3 et 75 caractères</div>';
		}

	if(empty($content))
		{
			$bdd->query("REPLACE INTO categorie(id_categorie,titre,motscles)VALUES('$_POST[id_categorie]','$_POST[titre]','$_POST[motscles]')");
			$content .= '<div class="validation">La categorie a bien été enregistré</div><br>';
		}
}

// --------------------SUPRESSION CATEGORIE --------------------------------------

if(isset($_GET['action']) && $_GET['action'] == 'suppression')
{
	$bdd->query("DELETE FROM categorie WHERE id_categorie= '$_GET[id_categorie]'");
	$content .="<div class ='validation'> La catégorie ". $_GET['id_categorie'] . " a été supprimé </div>";
}

// -------------------- LIENS AFFICHAGE OU AJOUT ------------------------------

$content .='<br><a href="?action=affichage">Liste des catégories</a><br><br>';
$content .='<a href="?action=ajout">Ajouter une catégorie</a><br><br><br>';

/************ AFFICHAGE DES CATEGORIES **************************************/

if(isset($_GET['action']) && $_GET['action'] == 'affichage')
{

$r = $bdd->query ("SELECT * FROM categorie");
	$content .= "<h2>Affichage des " . $r->rowCount() . " catégorie(s)</h2>";


	$content .= "<table class='table table-striped table-hover'><tr>.";



	for ($i=0; $i < $r->columnCount() ; $i++)
	{
		$colonne = $r->getColumnMeta($i);
		$content .= "<th >$colonne[name] </th>";
	}
	$content .= "<th '>actions</th>";
	$content .= '</tr>';

	while($ligne = $r->fetch(PDO::FETCH_ASSOC))
	{
		$content .='<tr>';
		foreach ($ligne as $indice => $valeur)
		{

				$content .= "<td>$valeur</td>";

		}
		$content .= "<td><a href=\"?action=modification&id_categorie=$ligne[id_categorie]\"> <span class=\"glyphicon glyphicon-pencil\"></span> </a><a href=\"?action=suppression&id_categorie=$ligne[id_categorie]\"> <span class=\"glyphicon glyphicon-trash\"> </a></td>";


		$content .= '<tr>';
	}
	$content .= '</table>';

}







require_once("../inc/haut.inc.php");
echo $content;


// MODIFICATION D'UNE CATEGORIE -----------------------------------------------

if((isset($_GET['action']) && $_GET['action'] == 'ajout') || (isset($_GET['action']) && $_GET['action'] == 'modification') )
{

	if(isset($_GET['id_categorie']))
	{
		$resultat =$bdd->query("SELECT * FROM categorie WHERE id_categorie = $_GET[id_categorie]"); // on récupère les informations sur l'article à modifier
		$categorie_actuelel = $resultat->fetch(PDO::FETCH_ASSOC); // on rend le sinfos exploitable afin de les présaisir dans les cases du formulaire
		//debug($produit_actuel);
	}

	$id_categorie = (isset($categorie_actuelel['id_categorie'])) ? $categorie_actuelel['id_categorie'] : '';
	$titre = (isset($categorie_actuelel['titre'])) ? $categorie_actuelel['titre'] : '';
	$motscles = (isset($categorie_actuelel['motscles'])) ? $categorie_actuelel['motscles'] : '';

// FORMULAIRE D'AJOUT MODIFICATION -----------------------------------------------

	echo
	'<h2>Formulaire d\'enregistrement d\'une catégorie</h2>

	<form method="post" action="" enctype="multipart/form-data">

		<input type="hidden" id="id_categorie" name="id_categorie" value="' . $id_categorie . '">

		<div class="form-group" style="width:25%;">
		<label for="titre">Titre</label>
		<input type="text" id="titre" name="titre" class="form-control" value="' . $titre . '">
		</div>


		<div class="form-group" style="width:25%;">
		<label for="motscles">Mots cles</label>
		<input type="text" id="motscles" name="motscles" class="form-control" value="' . $motscles . '">
		</div>

		<input type="submit" class="btn btn-success" value="Enregistrer la categorie">


	</form>
		';
}




require_once("../inc/bas.inc.php");

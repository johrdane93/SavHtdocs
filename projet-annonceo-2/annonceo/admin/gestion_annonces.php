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


// --------------------SUPRESSION ANNONCE --------------------------------------

if(isset($_GET['action']) && $_GET['action'] == 'suppression')
{
	$bdd->query("DELETE FROM produit WHERE id_produit= '$_GET[id_produit]'");
	$content .="<div class ='validation'> L'annonce n° ". $_GET['id_annonce'] . " a été supprimé </div>";
}

/************ AFFICHAGE DES ANNONCES **************************************/

if(empty($_GET) || $_GET['action'] == 'liste')
{

	$r = $bdd->query ("SELECT * FROM annonce");
	$content .= "<h2>Affichage des " . $r->rowCount() . " annonce(s)</h2>";


	$content .= "<table class='table table-striped table-hover'><tr>.";



	for ($i=0; $i < $r->columnCount() ; $i++)
	{
		$colonne = $r->getColumnMeta($i);
		$content .= "<th>$colonne[name] </th>";
	}
	$content .= "<th>actions</th>";
	$content .= '</tr>';

	while($ligne = $r->fetch(PDO::FETCH_ASSOC))
	{
		$content .='<tr class="table table-striped table-hover">';
		foreach ($ligne as $indice => $valeur)
		{
			if($indice == 'photo')
			{
				$content .= "<td><img src='$valeur' width='70' height='50'></td>";
			}
			else
			{
				$content .= "<td style='vertical-align:middle; text-align:center;'>$valeur</td>";
			}

		}
		$content .= "<td style='vertical-align:middle;'><a href=\"?action=modification&id_annonce=$ligne[id_annonce]\"><span class=\"glyphicon glyphicon-pencil\"></span> </a><a href=\"?action=supression&id_annonce=$ligne[id_annonce]\"> <span class=\"glyphicon glyphicon-trash\"></span> </a><a href=\"../fiche_annonce.php?id_annonce=$ligne[id_annonce]\"> <span class=\"glyphicon glyphicon-search\"></span> </a></td>";


		$content .= '<tr>';
	}
	$content .= '</table>';
}

// --------------------MODIFICATION ANNONCE --------------------------------------

if(isset($_GET['action']) == 'modification')
{

	if(isset($_GET['id_annonce']))
	{

		$resultat =$bdd->query("SELECT * FROM annonce WHERE id_annonce = $_GET[id_annonce]");

		$annonce_actuel = $resultat->fetch(PDO::FETCH_ASSOC);

		$id_annonce = (isset($annonce_actuel['id_annonce'])) ? $annonce_actuel['id_annonce'] : '';
		$titre = (isset($annonce_actuel['titre'])) ? $annonce_actuel['titre'] : '';
		$description_longue = (isset($annonce_actuel['description_longue'])) ? $annonce_actuel['description_longue'] : '';
		$description_longue = (isset($annonce_actuel['description_longue'])) ? $annonce_actuel['description_longue'] : '';
		$prix = (isset($annonce_actuel['prix'])) ? $annonce_actuel['prix'] : '';
		$photo = (isset($annonce_actuel['photo'])) ? $annonce_actuel['photo'] : '';
		$pays = (isset($annonce_actuel['pays'])) ? $annonce_actuel['pays'] : '';
		$ville = (isset($annonce_actuel['ville'])) ? $annonce_actuel['ville'] : '';
		$adresse = (isset($annonce_actuel['adresse'])) ? $annonce_actuel['adresse'] : '';
		$cp = (isset($annonce_actuel['cp'])) ? $annonce_actuel['cp'] : '';
		$membre_id = (isset($annonce_actuel['membre_id'])) ? $annonce_actuel['membre_id'] : '';
		$photo_id = (isset($annonce_actuel['photo_id'])) ? $annonce_actuel['photo_id'] : '';
		$categorie_id = (isset($annonce_actuel['categorie_id'])) ? $annonce_actuel['categorie_id'] : '';
		$date_enregistrement = (isset($annonce_actuel['date_enregistrement'])) ? $annonce_actuel['date_enregistrement'] : '';


	$content .= "<h3>Formulaire de modification</h3>";
	$formulaire = '<a href="?action=liste">Retour à la liste des annonces</a>';
	$content .= $formulaire;

	}
}






require_once("../inc/haut.inc.php");

echo $content;

require_once("../inc/bas.inc.php");


<?php
require_once ("inc/init.inc.php");

if (!internauteEstConnecte()) // si le membre n'est pas connecté, il ne doit pas avoir accés à la page profil

	{
	header("location:connexion.php"); // nous l'invitons à se connecter
	}

$content = '';
$content.= '<h1 class="text-center">Bonjour ' . $_SESSION['membre']['pseudo'] . '!<h1>';

// Information du profil de l'utilisateur

$content.= '<h2 class="text-center alert alert-info"> Les informations de votre profil </h2>';
$content.= '<ul class="list-group" ><li class="list-group-item"> Votre email est : ' . $_SESSION['membre']['email'] . '</li>';
$content.= '<li class="list-group-item"> Votre prénom est : ' . $_SESSION['membre']['prenom'] . '</li>';
$content.= '<li class="list-group-item"> Votre nom est : ' . $_SESSION['membre']['nom'] . '</li>';
$content.= '<li class="list-group-item"> Votre téléphone est : ' . $_SESSION['membre']['telephone'] . '</li>';
$content.= '<li class="list-group-item"> Vous êtes membre depuis : ' . $_SESSION['membre']['date_enregistrement'] . '</li>';;
if (internauteEstConnecteEtEstAdmin())
	{
	$content.= '<li class="list-group-item">Vous êtes ADMIN</li></ul>';
	}
  else
	{
	$content.= '<li class="list-group-item">Vous êtes MEMBRE</li></ul>';
	}

// ------- SUPPRESSION des annonces --------//

if (isset($_GET['action']) && $_GET['action'] == 'suppression')
	{

	// Executez une requete de suppression

	$bdd->query("DELETE FROM annonce WHERE id_annonce='$_GET[id_annonce]'");
	$content.= "<p class=\"alert alert-success\">L'annonce n° " . $_GET['id_annonce'] . " a été supprimée</p>";
	}

// Affichage des annonces en cours de l'utilisateur avec les commentaires de tous les utilisateurs


if(isset($_GET))
{
$r = $bdd->query("   SELECT annonce.titre, annonce.id_annonce,annonce.prix, annonce.date_enregistrement,commentaire.commentaire,commentaire.membre_id    FROM annonce LEFT JOIN commentaire ON annonce.id_annonce = commentaire.annonce_id ORDER BY annonce.date_enregistrement DESC");

$content.= "<h1 class=\"text-center\">Vous avez " . $r->rowCount() . " annonce(s)</h1>";
$content.= "<table class='table table-striped text-center'><tr>";

for ($i = 0; $i < $r->columnCount(); $i++)
	{
	$colonne = $r->getColumnMeta($i);
	$content.= "<th class=\"text-center\">$colonne[name]</th>";
	}

$content.= "<th>actions</th>";
$content.= "</tr>";

while ($ligne = $r->fetch(PDO::FETCH_ASSOC))
	{
	$content.= '<tr>';
	foreach($ligne as $indice => $valeur)
		{
		$content.= "<td>$valeur</td>";
		}

	$content.= "<td><a href=\"?action=modification&id_annonce=$ligne[id_annonce]\"><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a><a href=\"?action=suppression&id_annonce=$ligne[id_annonce]\"><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></td>";
	$content.= '</tr>';
	}
}

$content.= "</table>";



require_once ("inc/haut.inc.php");

echo $content;
require_once ("inc/bas.inc.php");

?>

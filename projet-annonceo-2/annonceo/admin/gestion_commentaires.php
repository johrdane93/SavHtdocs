<?php

require_once("../inc/init.inc.php");
if(!internauteEstConnecteEtEstAdmin())
{
	header("location:../connexion.php");
	exit(); // interrompt le script
}

	$content='';

		if(!empty($_POST)){


			//Sécurisation des champs du formulaire
	foreach($_POST as $indice => $valeur)
	{
		$_POST[$indice] = htmlspecialchars(addslashes($valeur));
	}



	if(!is_numeric($_POST['membre_id']))
	{
		$content .= '<div>Merci de renseigner un caractère numérique dans le champs membre_id</div>';
	}
	if(!is_numeric($_POST['annonce_id']))
	{
		$content .= '<div>Merci de renseigner un caractère numérique dans le champs annonce_id</div>';
	}
	if(strlen($_POST['commentaire']) < 11 || strlen($_POST['commentaire']) > 500)
	{
		$content .= '<div class="erreur">Merci de renseigner au moins 10 caractères dans le champs commentaire</div>';
	}

	if(empty($content)){



	$bdd->query("REPLACE INTO commentaire(id_commentaire,membre_id,annonce_id,commentaire) VALUES('$_POST[id_commentaire]','$_POST[membre_id]','$_POST[annonce_id]','$_POST[commentaire]')");
	   $content .= '<div>Le commentaire a bien été modifié!</div>';
	}

	}

//------- SUPPRESSION COMMENTAIRE --------//
if(isset($_GET['action']) && $_GET['action'] == 'suppression')
{
	// Executez une requete de suppression
	$bdd->query("DELETE FROM commentaire WHERE id_commentaire='$_GET[id_commentaire]'");
	$content .= "<div class=\"alert alert-success\">Le commentaire n° " . $_GET['id_commentaire'] . " a été supprimé</div>";
	$content .='<div class="col text-center"><a href="?action=affichage">Retourner sur la liste des commentaires</a></div>';

}

//Affichage des colonnes. A faire : intégrer l'email dans id_membre et le produit dans id_annonce

if(empty($_GET) ||$_GET['action']=='affichage'){


	$r = $bdd->query("SELECT commentaire.id_commentaire, commentaire.membre_id, membre.email, commentaire.annonce_id, annonce.titre,commentaire.commentaire,commentaire.date_enregistrement
		FROM commentaire
		LEFT JOIN membre ON commentaire.membre_id=membre.id_membre
		LEFT JOIN annonce ON commentaire.membre_id=annonce.membre_id");

	$content .= "<h1 class=\"text-center\">Affichage des " . $r->rowCount() . " commentaire(s)</h1>";
	$content .=  "<table class='table table-striped text-center'><tr>";
	for($i = 0; $i < $r->columnCount(); $i++)
	{
		$colonne = $r->getColumnMeta($i);

		$content .= "<th class=\"text-center\">$colonne[name]</th>";
	}
	$content .= "<th>actions</th>";
	$content .= "</tr>";
	while($ligne = $r->fetch(PDO::FETCH_ASSOC))
	{
		$content .= '<tr>';
		foreach($ligne as $indice => $valeur)
		{
			$content .= "<td>$valeur</td>";

		}
		$content .= "<td><a href=\"?action=modification&id_commentaire=$ligne[id_commentaire]\"><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a><a href=\"?action=suppression&id_commentaire=$ligne[id_commentaire]\"><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></td>";


		$content .= '</tr>';
	}
	$content .= "</table>";




}

require_once("../inc/haut.inc.php");

echo $content;

//******Modification d'un commentaire

if(isset($_GET['action']) && $_GET['action'] == 'modification')
{
	if(isset($_GET['id_commentaire']))
	{
		$resultat = $bdd->query("SELECT * FROM commentaire WHERE id_commentaire=$_GET[id_commentaire]"); // on récupère les informations sur le commentaire à modifier
		$commentaire_actuel = $resultat->fetch(PDO::FETCH_ASSOC); // on rend les informations exploitable afin de les présaisir dasn les cases du formulaire
		//debug($commentaire_actuel);
	}
	$id_commentaire = (isset($commentaire_actuel['id_commentaire'])) ? $commentaire_actuel['id_commentaire'] : '';
	$membre_id = (isset($commentaire_actuel['membre_id'])) ? $commentaire_actuel['membre_id'] : '';
	$annonce_id = (isset($commentaire_actuel['annonce_id'])) ? $commentaire_actuel['annonce_id'] : '';
	$commentaire = (isset($commentaire_actuel['commentaire'])) ? $commentaire_actuel['commentaire'] : '';
	$date_enregistrement = (isset($commentaire_actuel['date_enregistrement'])) ? $commentaire_actuel['date_enregistrement'] : '';

	// ***************Affichage du formulaire pour modifier



echo '<h1 class="text-center">Modifiez le commentaire n°'.$id_commentaire.'</h1><br>

	<div class="form-group row">
	<form method="post" action="">

			<input class="form-control" type="hidden" id="id_commentaire" name="id_commentaire" value="' . $id_commentaire . '">


	<div class="form-group row">
		<div class="col-10">
			<label for="membre_id" class="col-2 col-form-label" >membre_id</label>
			<input class="form-control" type="text" id="membre_id" name="membre_id" placeholder="membre_id" value="' . $membre_id . '">
		</div>
	</div>

	<div class="form-group row">
		<div class="col-10">
			<label for="annonce_id" class="col-2 col-form-label">annonce_id</label><br>
			<input class="form-control" type="text" id="annonce_id" name="annonce_id" placeholder="annonce_id" value="' . $annonce_id . '">
		</div>
	</div>

	<div class="form-group row">
		<div class="col-10">
			<label for="commentaire" class="col-2 col-form-label">commentaire</label><br>
			<input class="form-control" type="text" id="commentaire" name="commentaire" placeholder="commentaire" value="' . $commentaire . '">
		</div>
	</div>

	<div class="form-group row">
		<div class="col-10">
			<label for="date_enregistrement" class="col-2 col-form-label">date_enregistrement</label><br>
			<textarea class="form-control" id="date_enregistrement" name="date_enregistrement" placeholder="date_enregistrement">' . $date_enregistrement . '</textarea>
		</div>
	</div>



		<input type="submit" value="enregister">


	</form>
	</div>';

	echo '<div class="col text-center">
    		 <a href="?action=affichage">Retourner sur la liste des commentaires</a>
   		 </div>';


}

require_once("../inc/bas.inc.php");

?>

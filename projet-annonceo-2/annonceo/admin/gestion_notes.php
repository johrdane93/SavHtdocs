<?php

require_once("../inc/init.inc.php");
if(!internauteEstConnecteEtEstAdmin())
{
	header("location:../connexion.php");
	exit(); // interrompt le script
}

//Affichage du tableau

$content="";
if(empty($_GET) ||$_GET['action']=='affichage'){


	$r = $bdd->query("SELECT note.id_note,note.membre_id1,membre.id_membre,note.membre_id2,annonce.membre_id,note.note,note.avis,note.date_enregistrement
		FROM note
		LEFT JOIN membre ON membre.id_membre=note.membre_id1
		LEFT JOIN annonce ON annonce.membre_id=note.membre_id2");

	$content .= "<h1 class=\"text-center\">Gestion des notes</h1>";
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
		$content .= "<td><a href=\"?action=modification&id_commentaire=$ligne[id_note]\"><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a><a href=\"?action=suppression&id_commentaire=$ligne[id_note]\"><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></td>";


		$content .= '</tr>';
	}
	$content .= "</table>";




}



require_once ("../inc/haut.inc.php");


echo $content;


require_once ("../inc/bas.inc.php");
?>

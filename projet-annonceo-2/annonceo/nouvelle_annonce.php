<?php


require_once("inc/init.inc.php");
$content='';

if(!internauteEstConnecte())// si le membre n'est pas connecté, il ne doit pas avoir accés à la page profil
{
	header("location:connexion.php"); // nous l'invitons à se connecter
}

// séléctio ndes catégories

$select = $bdd->query('SELECT * from categorie');
$categories = $select->fetchAll();

//Insertion d'une annonce en BDD
if(!empty($_POST)){

	foreach($_POST as $indice => $valeur)
	{
		$_POST[$indice] = htmlspecialchars(addslashes($valeur));
	}
	if(strlen($_POST['titre']) < 6 || strlen($_POST['titre']) > 255)
	{
		$content .= '<div class="alert alert-danger">Merci de renseigner au moins 5 caractères pour le titre</div>';
	}
	if(strlen($_POST['description_courte']) < 11 || strlen($_POST['description_courte']) > 255)
	{
		$content .= '<div class="alert alert-danger">Merci de renseigner au moins 10 caractères pour la description courte</div>';
	}
		if(strlen($_POST['description_longue']) < 21)
	{
		$content .= '<div class="alert alert-danger">Merci de renseigner au moins 20 caractères pour la description longue</div>';
	}
	if(!is_numeric($_POST['prix']))
	{
		$content .= '<div class="alert alert-danger">Merci de renseigner un caractère numérique pour le prix</div>';
	}
	// if(!is_numeric($_POST['categorie_id']))
	// {
	// 	$content .= '<div class="alert alert-danger">Merci de renseigner un caractère numérique pour la catégorie</div>';
	// }

	if (!eregi("^([0-9]{5})$", $_POST['cp']))
	{
		$content .= '<div class="alert alert-danger">Le code postal doit être composé de 5 chiffres !</div>';
	}
	if(empty($content))
	{
	$bdd->query("INSERT INTO annonce(titre,description_courte,description_longue,prix,categorie_id,pays,ville,adresse,cp,photo)VALUES('$_POST[titre]','$_POST[description_courte]','$_POST[description_longue]','$_POST[prix]','$_POST[categorie_id]','$_POST[pays]','$_POST[ville]','$_POST[adresse]','$_POST[cp]'$_POST[photo]')");
	   $content .= '<div class="alert alert-success">L\'annonce  a bien été publiée sur le site</div>';


	}
}


require_once("inc/haut.inc.php");


echo $content;

?>


<h1 class="text-center">Déposer une nouvelle annonce</h1>
<div class="row">
   <div class="col-sm-12 col-md-6">
      <form method="post" action="">
         <div class="form-group">
            <label for="titre" class="col-2 col-form-label" >titre</label>
            <input class="form-control" type="text" id="titre" name="titre" placeholder="titre">
         </div>
         <div class=" form-group">
            <label for="description courte" class="col-2 col-form-label" >description courte</label>
            <input class="form-control" type="text" id="description courte" name="description_courte" placeholder="description courte">
         </div>
         <div class="form-group">
            <label for="description_longue" class="col-2 col-form-label">description longue</label><br>
            <input class="form-control" type="text" id="description longue" name="description longue" placeholder="description longue">
         </div>
         <div class="form-group">
            <label for="prix" class="col-2 col-form-label">prix</label><br>
            <input class="form-control" type="text" id="prix" name="prix" placeholder="prix">
         </div>
         <div class="form-group">
            <label for="categorie_id">Catégorie</label>
            <select name="categorie_id" id="categorie_id" class="form-control">
							<?php foreach ($categories as $key => $value): ?>
								<option value="<?= $value['id_categorie'] ?>"><?= $value['titre'] ?></option>
							<?php endforeach; ?>
            </select>
         </div>
	 </div>
   <!-- partie de droite -->
   <div class="col-sm-12 col-md-6">
	   	<div class="form-group">
	   		<label for="pays" class="col-2 col-form-label">pays</label><br>
	   		<input class="form-control" type="text" id="pays" name="pays" placeholder="pays">
	   </div>
	   <div class="form-group">
	   		<label for="ville" class="col-2 col-form-label">ville</label><br>
	   		<input class="form-control" type="text" id="ville" name="ville" placeholder="ville">
	   </div>
	   <div class="form-group ">
	   		<label for="adresse" class="col-2 col-form-label">adresse</label><br>
	   		<input class="form-control" type="text" id="adresse" name="adresse" placeholder="adresse">
	   </div>
	   <div class="form-group">
		   <label for="code postal" class="col-2 col-form-label">code postal</label><br>
		   <input class="form-control" type="text" id="code postal" name="cp" placeholder="code postal">
	   </div>
   </div>
	   <div class="form-group" method="post" action="reception.php" enctype="multipart/form-data">
				<label for="mon_fichier" class="col-2 col-form-label"> Photo Fichier (tous formats | max. 1 Mo)</label><br/>
				<input type="file" id="photo_id" name="MAX_FILE_SIZE" value="1048576" placeholder="photo">
	   </div>
   </div>
	 <input type="submit" value="enregister" class="btn btn-success">
   </form>
</div>

<?php

require_once("inc/bas.inc.php");


?>

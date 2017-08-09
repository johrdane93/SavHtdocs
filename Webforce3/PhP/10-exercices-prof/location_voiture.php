<?php
/*
   1- Vous créez un formulaire avec un menu déroulant avec les catégories A,B,C et D de véhicules de location et un champ nombre de jours de location. 

   2- Vous créez une fonction prixLoc qui calcule le prix total de la location en fonction du prix de la catégorie choisie (A : 30€, B : 50€, C : 70€, D : 90€) multiplié par le nombre de jours de location. Elle retourne la chaine "La location de votre véhicule sera de X euros pour Y jour(s)." où X et Y sont variables.

   3- Lorsque le formulaire est soumis, vous affichez le résultat.
 */

echo '<pre>'; print_r($_POST); echo '</pre>';

$message = '';
$categories = array('A' => 30, 'B' => 50, 'C' => 70, 'D' => 90);

function prixLoc($categorie, $nbJours){
	// Solution longue :
	switch($categorie){
		case 'A' : $prix = 30; break;
		case 'B' : $prix = 50; break;
		case 'C' : $prix = 70; break;
		case 'D' : $prix = 90; break;
	}

	$prixLoc = $nbJours * $prix;

	// Solution courte :
	global $categories;
	$prixLoc = $nbJours * $categories[$categorie]; // $categorie contient 'A' ou 'B' ou 'C' ou 'D', il s'agit ici de l'indice de l'array $categories. Ainsi $categories[$categorie] donne la valeur correspondante, c'est-à-dire le prix

	return "La location de votre véhicule sera de $prixLoc euros pour $nbJours jours.";
}

if(!empty($_POST)){
	// si lme formulaire est posté, on appelle la fonction pour afficher le prix de la location :
	$message = prixLoc($_POST['categorie'], $_POST['nbJours']);
}



?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Location de voiture</title>
 </head>
 <body>
 	<h1>Location de voiture</h1>
 	<?php echo $message; ?>
 	<form method="post" action="">
 		<select name="categorie">
 			<option disabled selected>choisissez une catégorie</option>
 			<option>A</option>
 			<option>B</option>
 			<option>C</option>
 			<option>D</option>
 		</select>

 		<input type="text" name="nbJours" placeholder="nombre de jours">
 		<input type="submit">
 	</form>
 </body>
 </html>
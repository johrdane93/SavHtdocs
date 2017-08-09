<?php
/* 
	1- Vous réalisez un formulaire "Votre devis de travaux" qui permet de saisir le montant des travaux de votre maison en HT et de choisir la date de construction de votre maison (bouton radio) : "plus de 5 ans" ou "5 ans ou moins". Ce formulaire permettra de calculer le montant TTC de vos travaux selon la période de construction de votre maison.

	2- Vous créez une fonction montantTTC qui calcule le montant TTC à partir du montant HT donné par l'internaute et selon la période de construction : le taux de TVA est de 10% pour plus de 5 ans, et de 20% pour 5 ans ou moins. La fonction retourne le résultat du calcul.

	3- Vous affichez le résultat calculé par la fonction au-dessus du formulaire : "Le montant de vos travaux est de X euros avec une TVA à Y% incluse."

*/
echo '<pre>'; print_r($_POST); echo '</pre>';

$contenu = '';

function coutTravaux($periode, $montant){
	$taxes = array('inf' => 10, 'sup' => 20);

	$prixTravaux = $montant * ( 1 + $taxes[$periode]/100);

	return "Les travaux de votre maison vous coûterons $prixTravaux euros.";
}
 
if(!empty($_POST)){
	$contenu = coutTravaux($_POST['periode'], $_POST['montant']);
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Devis travaux</title>
</head>
<body>
	<?php echo $contenu; ?>
	<form method="post">
		<div>
			<label>Montant HT de vos travaux</label>
			<input type="text" name="montant" placeholder="montant HT de vos travaux">
		</div>
		<div>
			<label>Période de construction</label>
			<input type="radio" name="periode" value="sup" checked>Plus de 5 ans
			<input type="radio" name="periode" value="inf"> 5 ans ou moins
		</div>
		<div>
			<input type="submit">
		</div>
	</form>
</body>
</html>














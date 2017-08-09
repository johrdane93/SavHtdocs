<?php
/*
    1- Créer une fonction qui retourne la conversion d'une date FR en date US ou inversement.
      Cette fonction prend 2 paramètres : une date et le format de conversion "US" ou "FR"
	  
	2- Vous validez que le paramètre de format est bien "US" ou "FR". La fonction retourne un message si ce n'est pas le cas.
*/

function conversion($date, $format){

	// Créer un objet date appelé $objetDate :
	$objetDate = new DateTime($date);

	// echo '<pre>';print_r(get_class_methods($objetDate)); echo '</pre>';

	if($format == 'FR'){
		return $objetDate->format('d-m-Y');
	} elseif($format == 'US'){
		return $objetDate->format('Y-m-d');
	} else {
		return 'Erreur sur le format demandé';
	}
}

echo conversion('10-02-2015', 'US') . '<br>';
echo conversion('02-10-2015', 'FR');
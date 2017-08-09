<?php
/*
	1- Vous réalisez un formulaire "Votre devis de travaux" qui permet de saisir le montant des travaux de votre maison en HT et de choisir la date de construction de votre maison (bouton radio) : "plus de 5 ans" ou "5 ans ou moins". Ce formulaire permettra de calculer le montant TTC de vos travaux selon la période de construction de votre maison.

	2- Vous créez une fonction montantTTC qui calcule le montant TTC à partir du montant HT donné par l'internaute et selon la période de construction : le taux de TVA est de 10% pour plus de 5 ans, et de 20% pour 5 ans ou moins. La fonction retourne le résultat du calcul.

	3- Vous affichez le résultat calculé par la fonction au-dessus du formulaire : "Le montant de vos travaux est de X euros avec une TVA à Y% incluse."

*/


echo '<pre>'; print_r($_POST);echo'</pre>';
$contenu =';'

//Ou
function coutTraveaux($montant,$periode){
  $taxes =array('inf'=> 1.1,'sup'=>1.2);
  $prixTravaux = $montant * $taxes[$periode];
  return "les travaux de votre maison voux couterons $prixTravaux euros.";
}
if(!empty)

// function montantTTC($_POST['prixht'], $coefmult)
//     {
//         $prixht = $_POST['prixht'];
//         $prixttc = $prixht * 1.196;
//         return $prixttc;
//     }
//
//     echo " le prix ttc est de $prixttc";

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>devis traveaux</title>
  </head>
  <body>
    <form class=""  method="post">
      <div>
        <label>montant HT de vos traveaux </label>
        <input type="text" name="montant" placeholder="Montant Ht de vos Traveaux">
      </div>
      <div>
        <label for="">periode de construction</label>
        <input type="radio" name="periode" value="sup" checked>plus de 5 ans
        <input type="radio" name="periode" value="inf">
      </div>
      <div>
        <input type="submit" >
      </div>

    </form>
  </body>
</html>

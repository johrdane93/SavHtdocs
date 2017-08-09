<?php
/*
   1- Vous créez un formulaire avec un menu déroulant avec les catégories A,B,C et D de véhicules de location et un champ nombre de jours de location.

   2- Vous créez une fonction prixLoc qui calcule le prix total de la location en fonction du prix de la catégorie choisie (A : 30€, B : 50€, C : 70€, D : 90€) multiplié par le nombre de jours de location. Elle retourne la chaine "La location de votre véhicule sera de X euros pour Y jour(s)." où X et Y sont variables.

   4- Lorsque le formulaire est soumis, vous affichez le résultat.

*/

// Calcul du prix de la location via la fonction prixLoc() //

$contenu = '';

function prixLoc($categorie, $jours){
  switch ($_POST['categorie']) {
    case 'A'  : $prix_jour = 30; break;
    case 'B'  : $prix_jour = 50; break;
    case 'C'  : $prix_jour = 70; break;
    case 'D'  : $prix_jour = 90; break;
    default   : return 'Veuillez saisir une catégorie valide !';
  }

  $resultat = $prix_jour * $jours; // Prix de la location à la journée

   global $categorie;
   $prixLoc = $nbjours * $categories['$categories']; // je c plus

  return "<p class='lead'> Le véhicule vaut $resultat € pour $_POST[jours] jours.</p>";
}

if(!empty($_POST)) {
  //echo "<pre>"; echo var_dump($_POST); echo "</pre>";
  $contenu .= prixLoc($_POST['categorie'], $_POST['jours'] );
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>location_voitures</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="inc/css/bootstrap.min.css">
  </head>

  <body>
    <h1 class="text-center">Déterminez le prix de votre location</h1>
    <form class="list-group" action="" method="post">
      <div class="form-group">
        <label for="">Saisissez votre catégorie : </label>
        <select  class="form-control" name="categorie">
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
          <option value="D">D</option>
        </select>
      </div>

      <div class="form-group ">
        <label for="">Nombre de jours : </label>
        <input class="form-control" type="text" placeholder="Saisissez la durée de votre location" name="jours">
      </div>

      <input class="btn btn-default" type="submit" name="validation" value="Valider">
    </form>

      <?php echo $contenu ?>

      <style>
        .form-group{
          width: 300px;
        }
      </style>
  </body>
</html>

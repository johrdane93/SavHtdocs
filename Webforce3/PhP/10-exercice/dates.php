<?php
/*
    1- Créer une fonction qui retourne la conversion d'une date FR en date US ou inversement.
      Cette fonction prend 2 paramètres : une date et le format de conversion "US" ou "FR"

	2- Vous validez que le paramètre de format est bien "US" ou "FR". La fonction retourne un message si ce n'est pas le cas.
*/

// Variables
$contenu = '';

// Fonction de conversion

function conversion($date, $format) {
$objetdate = new DateTime($date);

  if ($format == 'FR') {

    echo '<div class="bg-success">Date format Fr : ' . $objetdate->format('d-m-Y').'</div>';
  } elseif($format == 'US'){

    echo '<div class="bg-success">Date format US : ' . $objetdate->format('Y-m-d').'</div>';
  } else {
    echo '<div class="alert alert-danger">Veuillez entrer une date dans un format correct !</div>';
  }
}

  $contenu .= '<h1>Conversion date US - FR</h1>';

  $contenu .= '<form action="" method="post">';
  $contenu .=   '<label for="date">Saisissez votre date </label>';
  $contenu .=     '<p><input type="text"  name="date"> </p>';
  $contenu .=   '<label for="date">Saisissez votre format </label>';
  $contenu .=     '<p><input type="text"  name="format"> </p>';
  $contenu .=     '<input type="submit" class="btn" name="validation" value="Envoyer">';
  $contenu .= '</form>';

if(!empty($_POST)) {
  //echo "<pre>"; echo var_dump($_POST); echo "</pre>";
  $contenu .= conversion($_POST['date'], $_POST['format']);
}


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>conversion_Dates</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="inc/css/bootstrap.min.css">
  </head>

  <body>
    <?php echo $contenu ?>
  </body>
</html>

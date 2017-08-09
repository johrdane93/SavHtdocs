<?php

/* 1- Créer une base de données "restaurants" avec une table "restaurant" :
	  id_restaurant PK AI INT(3)
	  nom VARCHAR(100)
	  adresse VARCHAR(255)
	  telephone VARCHAR(10)
	  type ENUM('gastronomique', 'brasserie', 'pizzeria', 'autre')
	  note INT(1)
	  avis TEXT

	2- Créer un formulaire HTML (avec doctype...) afin d'ajouter un restaurant dans la bdd. Les champs type et note sont des menus déroulants que vous créez avec des boucles.

	3- Effectuer les vérifications nécessaires :
	   Le champ nom contient 2 caractères minimum
	   Le champ adresse ne doit pas être vide
	   Le téléphone doit contenir 10 chiffres
	   Le type doit être conforme à la liste des types de la bdd ('gastronomique', 'brasserie', 'pizzeria', 'autre')
	   La note est un nombre entre 0 et 5
	   L'avis ne doit pas être vide
	   En cas d'erreur de saisie, afficher des messages d'erreurs au-dessus du formulaire

	4- Ajouter le restaurant à la BDD et afficher un message en cas de succès ou en cas d'échec.

*/


//------------------ TRAITEMENT -------------------//

//  Connexion à la BDD //
$pdo = new PDO('mysql:host=localhost;dbname=restaurants', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

$type = array("gastronomie","brasserie","pizzeria", "autre");

// Vérifications du formulaire //
$message = '';


if(!empty($_POST)) {
  echo "<pre>"; var_dump($_POST); echo "</pre>";
  // Contrôle du formulaire
  if(strlen($_POST['nom']) <= 2 ) $message .='Le nom doit comporter au moins 2 caractères <br>';
  if(empty($_POST['adresse'])) $message .='Veuillez entrer votre adresse <br>';
  if(!preg_match("#^[0-9]{10}$#", $_POST['telephone'])) $message .= 'Veuillez entrer un numéro de téléphone valide <br>';
  if(!in_array($_POST['type'], $type)) $message .='Veuillez saisir un type de restaurant existant <br>';
  if(!(isset($_POST['note']) && $_POST['note'] > 0 && $_POST['note'] <= 5)) $message .= 'La note doit être comprise entre 0 et 5. <br>';
  if(!isset($_POST['avis'])) $message .='Merci de nous faire parvenir votre avis. <br>';

  if (empty($message)){
    foreach ($_POST as $indice => $valeur) {
      $_POST[$indice] = htmlspecialchars($_POST[$indice], ENT_QUOTES);
    }
  }

  $resultat = $pdo->prepare("INSERT INTO restaurant (nom, adresse, telephone, type, note, avis)
  VALUES (:nom, :adresse, :telephone, :type, :note, :avis)");

  $resultat->bindParam(':nom', $_POST['nom'], PDO::PARAM_STR);
  $resultat->bindParam(':adresse', $_POST['adresse'], PDO::PARAM_STR);
  $resultat->bindParam(':telephone', $_POST['telephone'], PDO::PARAM_STR);
  $resultat->bindParam(':type', $_POST['type'], PDO::PARAM_STR);
  $resultat->bindParam(':note', $_POST['note'], PDO::PARAM_INT);
  $resultat->bindParam(':avis', $_POST['avis'], PDO::PARAM_STR);

  $success = $resultat->execute();
    if ($success){
      echo "<div class='bg-success'>Félicitations, le restaurant a bien été ajouté !</div>";
    } else {
      echo "<div class='alert alert-danger'>Veuillez vérifier vos informations !</div>";
    }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ajout_restaurants</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="inc/css/bootstrap.min.css">
  </head>

  <body>
    <?php
    if(!empty($message)){
      echo "<div class='alert alert-danger'> $message </div>";
    }
    ?>
    <form action="" method="post">
      <div class="">
        <label for="nom">Nom</label><br>
        <input type="text" name="nom" value="">
      </div>

      <div class="">
        <label for="adresse">Adresse</label><br>
        <input type="text" name="adresse" value="">
      </div>

      <div class="">
        <label for="telephone">Téléphone</label><br>
        <input type="text" name="telephone" value="">
      </div>

      <div class="">
        <label for="type">Type</label><br>
        <?php
          echo "<select name='type'>";
            foreach ($type as $indice => $valeur) {
              echo "<option>$valeur</option>";
            }
          echo "</select>";
        ?>
      </div>

      <div class="">
        <label for="note">Note</label><br>
        <?php
          echo "<select name='note'>";
            for ($i=0; $i <= 5; $i++) {
              echo "<option> $i </option>";
            }
          echo "</select>";
        ?>
      </div>

      <div class="">
        <label for="avis">Avis</label><br>
        <textarea name="avis" rows="8" cols="80"></textarea>
      </div>

      <input type="submit" name="Valider" value="Envoyer">

    </form>

  </body>
</html>

<?php
// Exercice
/*
  -Crée un formulaire avec les champ ville , code postale et adresse
  -afficher Les Donner saisies par l'internaute juste au-dessu du formulaire en precisant l'etiquette correspondante.
*/
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Mon formulaire</title>
  </head>
  <body>
    <h1>Formulaire</h1>
    <form action="" method="post">
        <label for="ville">ville</label>
        <input type="text" name="ville" id="ville">
        <label for="description">Description</label>
        <textarea name="description" name"description"></textarea>
        <br>

        <input type="submit" name="validation" value="envoyer">
    </form>
  </body>
</html>

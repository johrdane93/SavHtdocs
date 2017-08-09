
<?php

echo '<pre>' ; var_dump($_POST); echo '</pre>' ;// pour veriffier que le formulaire fonctionne et envoies de infos

if(!empty($POST)){//si $_POST n'est pas vide c'est que le formulaire a été soumis
//afficher les données du formulaire :
echo 'prenom :' . $_POST['prenom'] . '<br>'; // l'indice de  $_POST correspond au name du formulaire
echo 'Description :' .$_POST['Description']. '<br>';
}


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
        <label for="prenom">prénom</label>
        <input type="text" name="prenom" id="prenom">
        <label for="description">Description</label>
        <textarea name="description" name"description"></textarea>
        <br>

        <input type="submit" name="validation" value="envoyer">
    </form>
  </body>
</html>

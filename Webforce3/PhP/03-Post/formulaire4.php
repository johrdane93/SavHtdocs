<?php
// Exercice
/*
-realiser un formulaire 'pseudo' et 'email' dans formulaire3.php
-recupérer les donner saisies dans le formulaire dans la page formulaire4.php et Les afficher

-De plus, si le champ pseudo est laisseé vide , aficher un message dans formulaire4.php

*/
echo '<pre>' ; var_dump($_POST); echo '</pre>';

if(!empty($_POST)){

  if(empty($_POST['pseudo'])){
    echo 'pseudo obligatoire';
  }else {
    echo '<p>Pseudo : ' . $_POST['pseudo'];'</p>';
    echo '<p>Email  :' .$_POST['email'];'</p>';
  }
}

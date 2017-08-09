<?php
/*
   Vous créez un tableau PHP contenant les pays suivants : France, Italie, Espagne, inconnu, Allemagne auxquels vous associez les valeurs Paris, Rome, Madrid, blablabla, Berlin.

   Vous parcourez ce tableau pour afficher la phrase "La capitale X se situe en Y" dans un paragraphe (où X remplace la capitale et Y le pays).

   Pour le pays "inconnu" vous afficherez "Ca n'existe pas !" à la place de la phrase précédente.

*/


$pays = array("France" => "Paris", "Italie" => "Rome", "Espagne" => "Madrid", "inconnu" => "blablabla", "Allemagne" => "Berlin" );

echo '<pre>'; var_dump($pays); echo '</pre>';

foreach ($pays as $indice => $valeur) {
  if ($indice != 'inconnu') {
    echo "<p>La capitale $valeur se situe en $indice. </p>";
    } else {
      echo "<p>Ce pays n'existe pas !</p>";
    }
}



?>

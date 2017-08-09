<?php
/*
//                        Exercice:
//-Faire 4 lien html avec le nom des fruite ( cerise, bananes,pomme,pêches)
//-Quand on clique sur un lien , on affiche  l prix du fruit shoisi pour 1000g(dans la page lien_fruits.php).
//-remarque : utiliser la fonction calcul( pour obtenire le prix tottale)*/

echo '<pre>' ; print_r($_GET); echo '</pre>';
include 'fonction.inc.php';
if(isset($_GET['fruit'])) echo calcul($_GET)['fruit'],1000 ;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>nos fruit</title>
  </head>
  <body>
    <h1>nos Fruit</h1>
    <a href="?fruit=cerise">cerise</a>
    <br>
    <a href="?fruit=pommes">pommes</a>
    <br>
    <a href="?fruit=bananes">bananes</a>
    <br>
    <a href="?fruit=peches">peches</a>
  </body>
</html>

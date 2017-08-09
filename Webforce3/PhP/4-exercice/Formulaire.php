<?php
/*Exercice
1.REaliser un formulaire permettant de selectionner un fruit dans une liste déroulante,et de saisire un poid dans un input.

2.traiter les information du formulaire pour afficher  le prix du fruit choisi pour le poids saisi (toujours en passant par la fonction calcul).
*/

include'fonction.inc.php';
if(!empty($_POST)){
  //si le formulaire at soumi ,$_POST n'est pas vide.
    echo ($_POST['fruit'],$_POST['poids']);
}
 ?>
 <h1>poids fruit</h1>
 <form  action="" method="post">


 <select name="fruits">
          <option value="cerise">cerise</option>
          <option value="bananes">bananes</option>
          <option value="pommes">pommes</option>
          <option value="peches">peches</option>
     </select>

     <input type="texte" name"poids" value="Go" title="selectioner le poids " />
     <input type="submit" value="calculer">
 </form>

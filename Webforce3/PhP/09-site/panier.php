<?php

require_once'inc\init.inc.php';
//traitement
debug( $_POST);
if (isset($_POST['ajout_panier'])){
  # si on n'a clique sur "ajouter au panier", on selectione les info(prix) du produit en BDD:
  $resultat = executeRequete("SELECT * FROM produit WHERE id_produit =:id_produit",array(':id_produit' =>$_POST['id_produit']));// l'id produit vien du formulaire

  $produit = $resultat->fetch(PDO::FETCH_ASSOC);// pas de boucle while car un seul produit

  ajouterproduitDanspanier($produit['titre'],$produit['id_produit'], $_POST['quantite'],$produit['prix']);// le prix vien de la bdd pour eviter qu'il soit modifier dans le navagateur et du coter serveur
  header('location:fiche_produit.php?statut_produit=ajoute&id_produit='.$produit['id_produit']);
  exit();
}
//vider le panier
if (isset($_GET['action'])&& $_GET['action'] == 'vider'){
  // si on a cliquer sur le lien
  unset($_SESSION['panier']);// onsupprime le panier*
}
//supprimer un article du panier
if (isset($_GET['action'])&& $_GET['action'] =='supprimer_article '&& isset($_GET['articleASupprimer'])){
  retirerProduit($_GET['articleASupprimer']);
  # code...
}
//validation du panier:
if (isset($_POST['valider'])) {
  # si on a clique sur le bouton valider du panier
  debug($_SESSION);

  $id_membre = $_SESSION['membre']['id_membre'];// l'id_membre et dans la session  a l'indice id_membre
  $montant_total= montanTotal();
  //On insere la commande dans la table dde commande
  executeRequete("INSERT INTO commande(id_membre,montant,date_enregistrement)VALUE (:id_membre,:montant,NOW())",array(':id_membre'=> $id_membre, ':montant'=> $montant_total ));
// on recupere l'id_commande de la commande que l'on vient d'inserer, pour pouvoir l'inserer enssuite dans la table details_commande:
  $id_commande = $pdo->lastInsertId();
  // on met a jour la table details_commande:
  for ($i=0; $i <count($_SESSION['panier']['id_produit']); $i++) {
    $id_produit =$_SESSION['panier']['id_produit'][$i];
    $quantite =$_SESSION['panier']['quantite'][$i];
    $prix =$_SESSION['panier']['prix'][$i];

    executeRequete("INSERT INTO details_commande(id_commande,id_produit,quantite,prix)VALUES(:id_commande,:id_produit,:quantite,:prix)",array(':id_commande'=>$id_commande, ':id_produit'=>$id_produit, ':quantite'=>$quantite,'prix'=>$prix));

    //décrémente le stock de chaque article:
    executeRequete("UPDATE produit SET stock = stock - :quantite WHERE id_produit = :id_produit", array(':quantite'=> $quantite, ':id_produit'=> $id_produit));
  }//fin du for
  //suppression du panier
  unset($_SESSION['panier']);
  $contenu .='<div class="bg-success">Merci pour votre commande. votre numero de suivit et le '.$id_commande.'</div>' ;
}

//affichage
require_once'inc\haut.inc.php';
echo $contenu;
echo '<h2>voici votre panier</h2>';
if (empty($_SESSION['panier']['id_produit'])) {
  echo '<p>votre panier est vide</p>';

}else {
  //lepanier n'est pas vide
echo ' <table class="table">';
echo '<tr class="info">
        <th>titre</th>
        <th>quantite</th>
        <th>prix unitaire</th>
        <th>action</th>
   </tr>';
//on affiche le produit en parcourant $_SESSION [panier]
for ($i=0; $i < count($_SESSION['panier']['id_produit']); $i++) {
  echo '<tr>';
      echo '<td>'.$_SESSION['panier']['titre'][$i].'</td>';
      echo '<td>'.$_SESSION['panier']['id_produit'][$i].'</td>';
      echo '<td>'.$_SESSION['panier']['quantite'][$i].'</td>';
      echo '<td>'.$_SESSION['panier']['prix'][$i].'</td>';
        echo '<td> <a href="?action=supprimer_article&articleASupprimer='.$_SESSION['panier']['id_produit'][$i].'">supprimer article<a/></td>';
          echo '</tr>';
}
// La ligne total du panier
echo'<tr class="info">
<th colspan="3">total</th>
<th colspan="2">'.montanTotal().'</th>
</tr>';

// Si internaute est connecté, on met le boutton  dr validation du panier ;
if (internauteEstConnecte()) {
  echo '<form method="post" action ="">
  <tr class="texte-center">
  <td colspan="5">
  <input type="submit" name="valider" value="valider le panier" class="btn">
  </td>
  </tr>
  </form>';
}else {
echo ' <tr class="texte-center">
<td colspan="5">
veullez vous <a href="inscription.php">inscrire</a> ou vous <a href="connection.php">conecter</a> afin de pouvoir valider le panier
</td>
</tr>';
}
echo ' <tr class="texte-center">
<td colspan="5">
veullez vous <a href="?action=vider">Vider Mon Panier</a>
</td>
</tr>';
echo'</table>';

}




 ?>

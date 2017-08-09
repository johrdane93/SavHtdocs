<?php
function debug($var){
    echo'<div style="background:orange; padding:5px;">';
      echo'<pre>'; print_r($var); echo'</pre>';
      echo '</div>';
}
//----------------Fonction membre*************************
function internauteEstConnecte(){
  if (isset($_SESSION['membre'])) {
    // si existe l'indice membre dans $_SESSION , c'est que  le membre est passe par le formulaire de connection avec les bons pseudo/MysqlndUhPreparedStatement
    return true;
  }else {
    return false;
  }
  //return (isset($_SESSION['membre']));
}
function internauteEstConnecteEtEstAdmin(){
  if (internauteEstConnecte() && $_SESSION['membre']['statut'] ==1 ){
      // si l'internaute et connecter et que sont statut vaut 1, alors il est ADMIN:
    return true;
  }else {
    return false;
  }
}// return (internauteEstConnecte() && $_SESSION['membre']['statut'] ==1 );


//-------------------------------------------------------
function executeRequete($req,$param = array()){
  if (!empty($param)) {
    // si j'ai recu des valeur assiciees aux marqueurs , je fais un html specialchars dessu pour les echapper:
    foreach ($param as $indice => $valeur) {
      $param[$indice]= htmlspecialchars($valeur,ENT_QUOTES);//evite l'es injection xss er css en neuytalisant les carateres >< "" etn &
    }
  }
  global $pdo; //permet d'avoir acces à la Variable defini dans l'espace global(dans init.inc.php)

  $r =$pdo->prepare($req);//on prepare la  requete recue en argument

  $succes = $r->execute($param);// on execute la requete en lui passant les parametres contenu dans $param

  if (!$succes) {
    // si la requete na pas fonctionne , execute renvoie le false :
    die('Erreur sur la requete SQL');// arrete le script et affiche le message
  }
  return $r;// on retourne un objet issub de la class PDOStatement
}

function creationPanier(){
   if (!isset($_SESSION['panier']['id_produit'])){
      $_SESSION['panier']=array();
      $_SESSION['panier']['titre'] = array();
      $_SESSION['panier']['id_produit'] = array();
      $_SESSION['panier']['quantite'] = array();
      $_SESSION['panier']['prix'] = array();
   }
   return true;
}


function ajouterproduitDanspanier($titre,$id_produit,$quantite,$prix){
creationPanier();

      //Si le produit existe déjà on ajoute seulement la quantité
      $positionProduit = array_search($id_produit,  $_SESSION['panier']['id_produit']);// retourne un chiffe si le produit existe qui corresponde a l'indice de celui dans le panier (0 pour le premier indice ).si le produit nest pas dans le panier arzry_search retourne false

      if ($positionProduit === false)
      {
         $_SESSION['panier']['titre'][] = $titre ;
         $_SESSION['panier']['id_produit'][] = $id_produit ;
         $_SESSION['panier']['quantite'][] = $quantite ;
         $_SESSION['panier']['prix'][] = $prix ;//crochets videsn pour ajouter a l'indice numerique suivant
      }
      else
      {
        $_SESSION['panier']['quantite'][$positionProduit] += $quantite ;
}
}



//calculer le montant totaledu panier
function montanTotal(){
  $total = 0;

  // onparcour le panier pour additionner las quantites fois les prix
  for ($i=0; $i <count($_SESSION['panier']['id_produit']) ; $i++) {
    $total += $_SESSION['panier']['quantite'][$i]*$_SESSION['panier']['prix'][$i];

    return round ($total,2);//

  }
}
//retirer un produit du panier
function retirerProduit($id_produit){
    $positionProduit =array_search($id_produit, $_SESSION['panier']['produit']);

    if ($positionProduit !==false) {
        array_splice($_SESSION['panier']['titre'],position_Produit,1);
        array_splice($_SESSION['panier']['id_produit'],position_Produit,1);
        array_splice($_SESSION['panier']['quantite'],position_Produit,1);
        array_splice($_SESSION['panier']['prix'],position_Produit,1);// coupe une tranche d'un array a partire l'indice positionProduit et sur 1 indice
    }
}


// fonction qui compte le nombre de produit differents dans le panier:
function quantiteProduit(){
  if (isset($_SESSION['panier'])){
    // si existe Panier
    return count($_SESSION['panier']['id_produit']);
  }else {
    return 0;
  }
}

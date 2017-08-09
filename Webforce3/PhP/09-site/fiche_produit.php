<?php
require_once('inc/init.inc.php');

//*********************TRAITEMENT**************************
$aside ='';
//1- Controle de l'existence du produit demané:
if (isset($_GET['id_produit'])) {
  // Si l'indice id_produit existe bien  on verifirt l'existance de l'id_produit en bdd
$resultat = executeRequete("SELECT * FROM produit WHERE id_produit = :id_produit",array(':id_produit' => $_GET['id_produit']));
if($resultat->rowCount()== 0 ){
  // si le produit n'existe pas en bdd on redirige vers la boutique :

}
//2eme mise en forme des information sur le produit
$produit = $resultat->fetch(PDO::FETCH_ASSOC);
$contenu .= '<div class="row">
              <div class="col-lg-12">
              <h1 class="page-header">'.$produit['titre'].'<h1>
              </div>
              </div>';

  $contenu.= '<div class="col-md-8"><img src="'.$produit['photo'].'" alt="" class="img-responsive"></div>';

  $contenu.= '<div class="col-md-4">
                <h3>description</h3>
                <p>'.$produit['description'].'</p>
                <h3>details</h3>

                <ul>
                  <li>categorie:'.$produit['categorie'].'</li>
                  <li>couleur:'.$produit['couleur'].'</li>
                  <li>taille:'.$produit['taille'].'</li>
                </ul>
                <p class="lead">prix:'.$produit['prix'].'€</p>
              </div>';

      //3-affichage du fromulaire d'ajout au panier si le stock est > 0
      $contenu .='<div class="col-md-4">';
          if ($produit['stock']>0) {
            // on cree le formulaire
            $contenu .= '<form method="post"action="panier.php">';
                $contenu .= '<input type="hidden" name="id_produit" value="'.$produit['id_produit'].'">';
                 $contenu .= '<select name="quantite" class="form-group-sm form-control-static">';
                 for ($i=1; $i <=$produit['stock'] && $i <= 5 ; $i++) {
                   $contenu .="<option>$i</option>";
                 }

                 $contenu .= '</select>';
                 $contenu .= '<input type="submit" name="ajout_panier" value="ajouter au panier" class="btn">';
          }else {
            $contenu .='<p>Produit indisponible</p>';
          }
          $contenu .= '<p><a href="boutique.php?categorie='. $produit['categorie'] .'">Retour vers votre selection </a></p>';
$contenu.='</div>';
}else {
// si id_produit n'existe pas dans l'url on redirige vers la boutique :
header('locations:boutique.php');
exit();
}

//Exercice01
/*--Cree des suggestion de produit : afficher 2 produis (photo et titre)aleatoirement appartenant a la categorie du produit selectioner par l'internaute .
-- Ces 2 produit doivent être different du produit affiche dans fiche_produit.
-- La photo et cliquable et renvoie a la fiche du produit.

- utilisez la variable $aside pour afficher le contenu.
Exercice02
--
--
--
--
*/
//affichage de la confirmation de l'ajout d'un article au panier:
if (isset($_GET['statut_produit'])&& $_GET['statut_produit'] =='ajoute') {
  # on construit le popup HTML :
  $contenu_gauche = '<div class="modal fade" id="MyModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                      <h4 class="modal-title">Le produit a ete ajoute !!!</h4>
                      </div>

                      <div class="modal-body">
                      <p><a href="panier.php">voir le panier</a></p>
                      <p><a href="boutique.php">Continuer ses achats</a></p>
                      </div>
                    </div>
                  </div>
                </div>';
}


//*********************AFFICHAGE**************************
require_once 'inc/haut.inc.php';
echo $contenu_gauche;
?>
<div class="row">
  <?php echo $contenu; ?>
</div>
<!--Suggestion de produits  -->
<div class="row">
  <div class="col-lg-12">
    <h3 classe=page-header>Suggestion de produits</h3>
  </div>
  <?php echo $aside; ?>
</div>
<script>
$(function(){
    $("#MyModal").modal("show");
});

</script>
<?php
require_once 'inc/bas.inc.php';

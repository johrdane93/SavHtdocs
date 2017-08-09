
<div class="row">
   <div class="col-md-3">
<p class="lead">Vêtements</p>
<div class="list-group">
  <a href="" class="liste-group-item">Tous</a>
    <?php  foreach ($categories as $cat ) :?>
      <a href="" class="liste-group-item"><?= $cat['Categorie'] ?></a>
    <?php endforeach; ?>
  </div>
  </div>

    <div class="col-md-9">
     <div class="row">
       <?php foreach ($produits as $produit ) : ?>
         <div class="col-sm-4">
           <div class="thumbnail">
             <a href=""><img src="photo/<?=$produit['photo']?>" width="130" height="100"></a>
             <div class="caption">
               <h4 class="pull-right"><?= $produit["prix"]?>€</h4>
                 <h4><?= $produit["titre"]?></h4>
                 <p><?= $produit["description"]?></p>
             </div>
           </div>
         </div>
       <?php endforeach; ?>
     </div>
   </div>
 </div>

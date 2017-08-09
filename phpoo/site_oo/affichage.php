<?php

$pdo = new PDO('mysql:host=localhost;dbname=site','root','');
$categories = $pdo -> query("SELECT DISTINCT categorie FROM produit");
?>
<p class="lead">Vêtement</p>
<div class="list-group">
  <a href="?categorie=all" class="list-group-item">Tous</a>

<?php while ($cat = $categorie -> fetch(PDO::FETCH_ASSOC)) : ?>

  <a href="?categorie=<?= $cat['categorie']?>" class="list-group-item"></a>
  ?




</div>

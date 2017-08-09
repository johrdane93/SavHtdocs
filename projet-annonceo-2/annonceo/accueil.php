<?php

require_once('inc/init.inc.php');

// requete pour annonce

$annonces = $bdd->query('SELECT
  annonce.titre, annonce.description_courte, annonce.prix, annonce.id_annonce, membre.pseudo, note.note
  FROM annonce
  LEFT JOIN membre ON membre.id_membre = annonce.membre_id
  LEFT JOIN note ON annonce.membre_id = note.membre_id1

  ');
//  LIMIT 0, 3

$results_annonces = $annonces->fetchAll(PDO::FETCH_ASSOC);


// requete pour categories

$categories = $bdd->query('SELECT * FROM categorie');

$results_categories = $categories->fetchALL(PDO::FETCH_ASSOC);


// requete pour région


// requete pour membres

$membres = $bdd->query('SELECT * FROM membre');

$results_membres = $membres->fetchAll(PDO::FETCH_ASSOC);

// requete pour prix

require_once('inc/haut.inc.php');

 ?>

  <div class="row">

    <!-- affichage des annonces -->
    <div class="col-sm-12 col-md-4" id="filtres">
      <form action="inc\api.php" method="post" id="form_filtres_gauche">
        <label for="select_categorie">Catégories</label>
        <select class="form-control" name="categorie" id="select_categorie">
        <option value="">Toutes les catégories</option>
        <?php foreach ($results_categories as $key2 => $value2): ?>
          <option value="<?= $value2['id_categorie'] ?>"><?= $value2['titre'] ?></option>
        <?php endforeach; ?>
      </select>
        <br>
        <label for="select_membre">Membres</label>
        <select class="form-control" name="membre" id="select_membre">
          <option value="">Tous les membres</option>
        <?php foreach ($results_membres as $key3 => $value3): ?>
          <option value="<?= $value3['id_membre'] ?>"><?= $value3['pseudo'] ?></option>
        <?php endforeach; ?>
      </select><br>
      </form>
    </div>

    <!-- affichage du form de gauche -->
    <div class="col-sm-12 col-md-8" id="annonces">

      <?php foreach ($results_annonces as $key => $value): ?>

      <div class="panel panel-default">
        <a href="fiche_annonce.php?id_annonce=<?= $value['id_annonce'] ?>">
          <h4 class="text-center"><?= $value['titre'] ?></h3>
          <div class="panel-body">
            <div class="media">
              <div class="media-left">
                <img class="media-object" src="<?= $value['photo'] ?>" alt="">
              </div>
              <div class="media-body">
                <span><?= $value['description_courte'] ?></span>
              </div>
              </div>
          <span><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?= $value['pseudo'] . '  ' . stars($value['note']) ?></span>
          <span class=""><?= $value['prix'] ?> <span class="glyphicon glyphicon-eur" aria-hidden="true"></span></span>
          </div>
        </a>

      </div>
      <?php endforeach; ?>


    </div>

  </div>

  <!--*************************** fin de page ************************************** -->

  <?php require_once('inc/bas.inc.php'); ?>

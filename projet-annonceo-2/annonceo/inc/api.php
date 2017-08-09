<?php

require_once('inc/init.inc.php');

if (!empty($_POST)) {

  // si filtre catégorie

  if (!empty($_POST['categorie']) && empty($_POST['membre'])) {
    $categorie = htmlspecialchars($_POST['categorie']);
    $annonces = $bdd->query("SELECT
      annonce.titre, annonce.description_courte, annonce.prix, annonce.id_annonce, membre.pseudo, note.note, annonce.categorie_id
      FROM annonce
      LEFT JOIN membre ON membre.id_membre = annonce.membre_id
      LEFT JOIN note ON annonce.membre_id = note.membre_id1
      WHERE categorie_id = '$categorie'
      ");

    // si filtre membre

    }elseif (!empty($_POST['membre']) && empty($_POST['categorie'])) {
    $membre = htmlspecialchars($_POST['membre']);
    $annonces = $bdd->query("SELECT
      annonce.titre, annonce.description_courte, annonce.prix, annonce.id_annonce, membre.pseudo, note.note, annonce.categorie_id
      FROM annonce
      LEFT JOIN membre ON membre.id_membre = annonce.membre_id
      LEFT JOIN note ON annonce.membre_id = note.membre_id1
      WHERE id_membre = '$membre'
      ");

  // si pas de filtre

}elseif (!empty($_POST['membre']) && !empty($_POST['categorie'])) {
    $categorie = htmlspecialchars($_POST['categorie']);
    $membre = htmlspecialchars($_POST['membre']);
    $categorie = htmlspecialchars($_POST['categorie']);
    $annonces = $bdd->query("SELECT
      annonce.titre, annonce.description_courte, annonce.prix, annonce.id_annonce, membre.pseudo, note.note, annonce.categorie_id
      FROM annonce
      LEFT JOIN membre ON membre.id_membre = annonce.membre_id
      LEFT JOIN note ON annonce.membre_id = note.membre_id1
      WHERE id_membre = '$membre' AND categorie_id = '$categorie'
      ");
  }else {
    $annonces = $bdd->query('SELECT
      annonce.titre, annonce.description_courte, annonce.prix, annonce.id_annonce, membre.pseudo, note.note
      FROM annonce
      LEFT JOIN membre ON membre.id_membre = annonce.membre_id
      LEFT JOIN note ON annonce.membre_id = note.membre_id1

      ');
  }

$results_annonces = $annonces->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results_annonces);

}


 ?>

<?php
  require_once '/inc/init.inc.php';


  // Inscription du membre en base de données
  $inscription = false; // pour ne pas afficher le formulaire une fois le membre inscrit

// debug($_POST);

// Traitement du formulaire //
if(!empty($_POST)){
  // Contrôles :
  if(strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 20){
    $contenu .= '<div class="bg-danger">Le nom doit contenir entre 2 et 20 caractères.</div>';
  }
  if(strlen($_POST['prenom']) < 4 || strlen($_POST['prenom']) > 20){
    $contenu .= '<div class="bg-danger">Le prenom doit contenir entre 4 et 20 caractères.</div>';
  }
  if(strlen($_POST['pseudo']) < 4 || strlen($_POST['pseudo']) > 20){
    $contenu .= '<div class="bg-danger">Le pseudo doit contenir entre 4 et 20 caractères.</div>';
  }
  if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    $contenu .= '<div class="bg-danger">L\'email n\'est pas valide !</div>';
  }

  if(empty($contenu)){
    $membre = executeRequete('SELECT * FROM membres WHERE pseudo = :pseudo', array(':pseudo' => $_POST['pseudo']));

    if($membre->rowCount() > 0){
      $contenu .= '<div class="bg-danger">Pseudo indisponible, veuilez en choisir un autre</div>';
    } else {
      $_POST['mdp'] = md5($_POST['mdp']); // on encrypte le mot de passe avec la fonction prédéfinie md5
      executeRequete('INSERT INTO membres (pseudo, nom, prenom, email, mdp) VALUES (:pseudo, :nom, :prenom, :email, :mdp)',
      array(':pseudo'=>$_POST['pseudo'],
            ':nom'=>$_POST['nom'],
            ':prenom'=>$_POST['prenom'],
            ':pseudo'=>$_POST['pseudo'],
            ':mdp'=>$_POST['mdp'],
            ':email'=>$_POST['email']));
      $contenu .= '<div class="bg-succes">Vous êtes inscrit sur notre site.<a href="connexion.php">Cliquez ici pour vous connecter</a></div>';
      $inscription = true; // pour ne plus afficher le formulaire
    }
  }
}

  require_once('inc/haut.inc.php');
  echo $contenu;
?>

<form action="" method="post" class="form-horizontal">
  <fieldset>

  <legend>Inscription</legend>

  <div class="form-group">
    <label class="col-md-4 control-label" for="nom">Nom</label>
    <div class="col-md-4">
      <input id="nom" name="nom" placeholder="Votre nom..." class="form-control input-md" type="text">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-4 control-label" for="prenom">Prénom</label>
    <div class="col-md-4">
      <input id="prenom" name="prenom" placeholder="Votre prénom..." class="form-control input-md" type="text">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-4 control-label" for="pseudo">Pseudo</label>
    <div class="col-md-4">
      <input id="pseudo" name="pseudo" placeholder="Votre pseudo..." class="form-control input-md" required="" type="text">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-4 control-label" for="email">Email</label>
    <div class="col-md-4">
      <input id="email" name="email" placeholder="Votre email..." class="form-control input-md" required="" type="text">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-4 control-label" for="mdp">Mot de passe</label>
    <div class="col-md-4">
      <input id="mdp" name="mdp" placeholder="Votre mot de passe..." class="form-control input-md" required="" type="password">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-4 control-label" for="inscription">Inscription</label>
    <div class="col-md-4">
      <button id="inscription" name="inscription" class="btn btn-primary">Inscription</button>
    </div>
  </div>

  </fieldset>
</form>

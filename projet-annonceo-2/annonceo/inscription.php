<?php

require_once('inc/init.inc.php');



if (!empty($_POST)) {

  // création de variables pour insertion du nouveau membre

  $pseudo = htmlspecialchars($_POST['pseudo']);
  $email = htmlspecialchars($_POST['email']);
  $password = htmlspecialchars($_POST['password']);
  $telephone = htmlspecialchars($_POST['telephone']);
  $nom = htmlspecialchars($_POST['nom']);
  $prenom = htmlspecialchars($_POST['prenom']);
  $civilite = htmlspecialchars($_POST['civilite']);
  $error = '';


  // contrôle de conformité pour les différents champs

  //champs pseudo : déjà existant
  $sel_pseudo = $bdd->query("SELECT pseudo FROM membre WHERE pseudo = '$pseudo'");
  if ($sel_pseudo->rowCount() >= 1) {
    $error .= 'Désolé, ce pseudo est déjà pris !<br />';
  };

  //champs pseudo : entre 3 et 20 caractères et - _
  if (!preg_match("/^[a-zA-Z0-9_-]{3,20}$/", $pseudo)) {
    $error .= 'Attention ! Votre pseudo doit contenir entre 3 et 20 caractères et seulement les caractères - (tiret) et _ (underscore) !<br />';
  };

  //champs email : email valide
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error .= 'Merci d\'indiquer une email valide !<br />';
  };

  //champs téléphone : numéro à 10 chiffres commençant par 0
  if (!preg_match("#^0[1-68]([-. ]?[0-9]{2}){4}$#", $telephone)) {
    $error .= 'Merci d\'indiquer un numéro de téléphone valide !<br />';
  };

  // si pas d'erreur : insertion
  if (empty($error)) {
    $insert = $bdd->prepare('INSERT INTO membre (pseudo, email, mdp, telephone, nom, prenom, civilite) VALUES (?, ?, ?, ?, ?, ?, ?)');

    $insert->execute(array($pseudo, $email, $password, $telephone, $nom, $prenom, $civilite));

    //header('location:profil.php');

  }else {
    // si erreur
    echo $error;
  }


}

require_once('inc/haut.inc.php');
 ?>

  <!-- **************** formulaire d'insertion d'un nouveau membre ************************ -->

<h1 class="text-center">Inscription</h1>
  <div class="col-sm-12">
    <form class="" method="post">

      <div class="col-sm-12 col-md-4">
        <div class="form-group">
          <label class="" for="pseudo">Pseudo</label>
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
            <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="pseudo">
          </div>
        </div>
      </div>

      <div class="col-sm-12 col-md-4 col-md-offset-4">
        <div class="form-group">
          <label class="" for="email">Email</label>
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
            <input type="email" class="form-control" id="email" name="email" placeholder="email">
          </div>
        </div>
      </div>

      <div class="col-sm-12 col-md-4">
        <div class="form-group">
          <label class="" for="password">Mot de passe</label>
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
            <input type="password" class="form-control" id="password" name="password" placeholder="password">
          </div>
        </div>
      </div>

      <div class="col-sm-12 col-md-4 col-md-offset-4">
        <div class="form-group">
          <label class="" for="telephone">Téléphone</label>
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
            <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="telephone">
          </div>
        </div>
      </div>

      <div class="col-sm-12 col-md-4">
        <div class="form-group">
          <label class="" for="nom">Nom</label>
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
            <input type="text" class="form-control" id="nom" name="nom" placeholder="nom">
          </div>
        </div>
      </div>

      <div class="col-sm-12 col-md-4 col-md-offset-4">
        <div class="form-group">
          <label class="" for="prenom">Prénom</label>
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="prenom">
          </div>
        </div>
      </div>

      <div class="col-sm-12 col-md-2">
        <div class="form-group">
          <label class="" for="civilite">Civilité</label>
          <select class="form-control" name="civilite">
             <option value="m">Homme</option>
             <option value="f">Femme</option>
           </select>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12 col-sm-offset-5">
          <div class="form-group">
            <button class="btn btn-primary" type="submit">Enregistrer</button>
          </div>
        </div>

      </div>
    </form>
  </div>

  <!--******************************* fin de page ******************************* -->

  <?php

require_once('inc/bas.inc.php');

  ?>

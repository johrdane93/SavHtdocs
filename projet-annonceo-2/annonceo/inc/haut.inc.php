<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Annonceo</title>

  <!-- CSS BOOSTRAP -->

  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!-- CSS ANNONCEO -->

  <link rel="stylesheet" href="inc/css/style.css">

  <!-- jQuery -->

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
  </script>

  <!-- JS BOOTSTRAP -->

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>

<body>

  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        <a class="navbar-brand" href=" <?=URL; ?>accueil.php">Annonceo</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li><a href="http://www.caf.fr/presse-institutionnel/qui-sommes-nous">Qui sommes-nous ?</a></li>
          <li><a href="https://www.fnac.com/Contact">Contact</a></li>
          <li><a href="<?php echo URL ?>nouvelle_annonce.php">Déposer une nouvelle annonce</a></li>

        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Espace membre<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <?php if (internauteEstConnecte()): ?>
              <li><a href="profil.php">Profil</a></li>
              <li><a href="connexion.php?action=deconnexion">deconnexion</a></li>
              <?php else: ?>
              <li><a href="connexion.php">Connexion</a></li>
              <li><a href="inscription.php">Inscription</a></li>

              <?php endif;
          if (internauteEstConnecteEtEstAdmin()): ?>
              <li><a href="<?php echo URL ?>admin/gestion_annonces.php">Gestion des annonces</a></li>
              <li><a href="<?php echo URL ?>admin/gestion_categories.php">Gestion des catégories</a></li>
              <li><a href="<?php echo URL ?>admin/gestion_commentaires.php">Gestion des commentaires</a></li>
              <li><a href="<?php echo URL ?>admin/gestion_membres.php">Gestion des membres</a></li>
              <li><a href="<?php echo URL ?>admin/gestion_notes.php">Gestion des notes</a></li>
              <li><a href="<?php echo URL ?>admin/statistiques.php">Statistiques</a></li>
              <?php endif; ?>
            </ul>
          </li>
        </ul>
      </div>
      <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
  </nav>

  <!-- main container -->
  <div class="container">

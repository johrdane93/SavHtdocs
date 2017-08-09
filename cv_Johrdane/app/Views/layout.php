<!DOCTYPE html>
<html ng-app="myApp">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Multipage Example</title>

    <!-- Bibliothèques -->
    <script src="https://code.jquery.com/jquery.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.2/angular.min.js"></script>

    <!-- Ajoutez la bibliothèque ui-router ici -->

    <!-- Code personnalisé -->
    <script src="js/app.js"></script>
    <link href = "css/app.css" rel="stylesheet" type = "text/css"/>

  </head>
  <body>
    <div>
      <header>

        <!-- Créez des liens vers différentes sections -->
          <h1>C'est l'en-tête - il va rester autour</h1>
          <a  class="btn btn-default" href="<?= $this->url('default_home') ?>">Home</a>
          <a  class="btn btn-default" href="<?= $this->url('default_Contact') ?>">Contact</a>
          <a  class="btn btn-default" href="<?= $this->url('CompetancesTechniques') ?>">Competances Techniques</a>
          <a  class="btn btn-default" href="<?= $this->url('a_propos') ?>">A Propos</a>
          <!-- <a  class="btn btn-default" href="<?= $this->url('') ?>">Console</a> -->


  		</header>


      <div class="container">
        <section>
          <?= $this->section('main_content') ?>
        </section>
        <div ui-view></div>

      </div>

      <footer>
          <h2>(Ceci est le pied de page )</h2>
      </footer>
    </div>
  </body>
</html>

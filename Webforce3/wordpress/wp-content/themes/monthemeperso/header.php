<!DOCTYPE html>
<html>
  <head  <?php language_attributes(); ?>>

    <meta charset="<?php bloginfo('charset');?>">
    <title><?php bloginfo('name');?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>\style.css">
    <link rel="stylesheet" href="<?php bloginfo('template_directory');?>\css\bootstrap.min.css">
    <link rel="stylesheet" href="https:fonts.googleapis.com/css?family=Roboto">
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); // rappel des class wordpress?>>

     <div class="container-fluid">
       <div class="row">
         <div class="col-md-6 vert haut-gauche">
           <?php dynamic_sidebar('haut-gauche'); ?>
         </div>
         <div class="col-md-6 orange haut-droite">
           <?php dynamic_sidebar('haut-droite'); ?>
         </div>
       </div>
       <div class="row">
         <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Project name</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#">About</a></li>
              <li><a href="#">Contact</a></li>

            </ul>

          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
       </div>

       <div class="row">
         <div class="col-md-10 bleu entete">
           <?php dynamic_sidebar('entete'); ?>
         </div>

       </div>
     </div>


<div class="container">
<section>

</section>

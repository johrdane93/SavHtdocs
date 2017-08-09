<?php  get_header();// La fonction get_header permet de rappatri" toute la partie header dans la page index, c'est un fonction propre a wordpress ?>

<?php if(have_posts() ) : while(have_posts() ) : the_post();//tant qu'il y a des arcticle en bdd , on boucle et on les affiche ?>

<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>


 <!-- Affiche le corps (Content) de l'Article dans un bloc div. -->
 <div class="contenu">
   <?php the_content(); ?>
 </div>
 <?php endwhile; else:  ?>
   <p>contenu non trouvé.</p>
 <?php endif;  // fin de la condition if si  il n'y a pas de contenu on affiche un message?>
 <?php get_footer(); // La fonction get_footer permet de rapatrié toute la partie footer dans la page index c'est une fonction propre a wordpress?>

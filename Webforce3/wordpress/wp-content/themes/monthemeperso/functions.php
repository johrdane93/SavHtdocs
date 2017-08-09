<?php
add_action('widgets_init','monthemeperso_init_sidebar'); // add_action() permet d'accrocher une fonction wordpress et de pouvoir l'utiliser c'est ce que l'on appele un'hook'

function monthemeperso_init_sidebar(){

  register_sidebar(array('name'=> __('haut-gauche','monthemeperso'),
                          'id' => 'haut-gauche',
                          'description'=> __('region en haut a gauche','monthemeperso')

  ));

  register_sidebar(array('name'=> __('haut-droit','monthemeperso'),
                          'id' =>'haut-droite',
                          'description'=> __('region en haut a droite','monthemeperso')

  ));

  register_sidebar(array('name'=> __('entete','monthemeperso'),
                          'id' =>'entete',
                          'description'=> __('entete','monthemeperso')

  ));
  register_sidebar(array('name'=> __('bas-droit','monthemeperso'),
                          'id' =>'bas-droit',
                          'description'=> __('bas-droit','monthemeperso')

  ));
  register_sidebar(array('name'=> __('bas-gauche','monthemeperso'),
                          'id' =>'bas-gauche',
                          'description'=> __('bas-gauche','monthemeperso')

  ));
}

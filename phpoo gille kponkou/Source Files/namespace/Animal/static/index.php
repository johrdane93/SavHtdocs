<?php


/*
 * l'opérateur::d'accéder à une constante de la classe
 */

require './Human.php';
echo Human::NB_LEGS;
$human = new human();
echo '<br>';
echo Human::$nbInstances;
echo '<br>' . $human::NB_LEGS;

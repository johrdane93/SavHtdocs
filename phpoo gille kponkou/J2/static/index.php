<?php

require './Human.php';

/**
 * l'opérateur :: permet d'accéder à une constante de la classe
 */
echo Human::NB_LEGS;

$human = new human();
echo '<br>';
echo Human::$nbInstances;
echo '<br>' . $human::NB_LEGS;


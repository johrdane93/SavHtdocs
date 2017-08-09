<?php

require('model.php');

$infos = afficheAll();

$produits = $infos['produits'];
$categories = $infos['categories'];

require('view.php');

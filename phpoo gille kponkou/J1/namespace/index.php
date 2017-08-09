<?php

require './Animal/Elephant.php';
require './Animal/continent/Africa/Elephant.php';
require './Animal/continent/Asia/Elephant.php';
require'./Tourist.php';

// grâce au use, new Elephant() = new Animal\continent\Africa\Elephant();


// use avec alias: la class AsianElephant
// n'existe pas mais fait référence à la classe
// Animal\continent\Asia\Elephant

use Animal\Continent\Africa\Elephant;
use Animal\continent\Asia\Elephant as AsianElephant;

$elephant = new Elephant();
$asianElephant = new AsianElephant();

echo '<hr>';

$tourist = new Tourist();
$tourist ->watchElephant('africa');
echo '<br>';
$tourist->watchElephant('asia');

echo '<hr>';
$asianElephant->beSeen();

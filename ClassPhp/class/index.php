<?php
include 'voiture.php';

$bugatie = new voiture('volkswagen' , 'bon ');

foreach ($bugatie-> getInfo() as $key ) {
echo '<p>' .$key.'</p>';
}

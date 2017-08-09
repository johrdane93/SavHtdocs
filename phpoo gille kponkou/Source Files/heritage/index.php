<?php

require 'chat.php';
require 'chien.php';
require './Maitre.php';


$chat =new Chat();

echo $chat->identifier();
echo '<br>';
echo $chat->getEspece();
echo '<br>';
echo $chat->crier();


echo '<hr>';

$chien =new chien();

echo $chien->identifier();
echo '<br>';
echo $chien->getEspece();
echo '<br>';
echo $chien->crier();

echo '<br>';

echo get_class($chat);

$Maitre = new Maitre();
$Maitre->setAnimal($chat);
$Maitre->caresserAnimal();
echo'<br>';

$Maitre2=new Maitre();
$Maitre2->setAnimal($chien);
$Maitre2->caresserAnimal();

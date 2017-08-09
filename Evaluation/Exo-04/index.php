<?php
include 'class.php';



$minou = new Chat();
$minou -> setPrenom('Hercule');
$minou -> setAge(5);
$minou -> setCouleur('bleue');
$minou -> setSexe('Male');
$minou -> setRace('Mattou');
$minou -> getInfos();


$mattou = new Chat();
$mattou -> setPrenom('Penellope');
$mattou -> setAge(7);
$mattou -> setCouleur('rouge');
$mattou -> setSexe('Femelle');
$mattou -> setRace('Persian');
$mattou -> getInfos();

$minou = new Chat();
$minou -> setPrenom('Mistigrie');
$minou -> setAge(75);
$minou -> setCouleur('noir');
$minou -> setSexe('Male');
$minou -> setRace('Zombie');
$minou -> getInfos();

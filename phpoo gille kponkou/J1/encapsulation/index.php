<?php

require './User.php';

$user = new User();
var_dump($user->getFirstName());
//echo $user->firstName;

//appel au setter pour modifier la valeur de l'attribut

$user 
        ->setFirstName('Gilles')
        ->setLastName('KPONKOU')
        ->setAge(40);

// appell au getter pour accéder  
// à la valeur de l'attribut

echo $user->getFirstName();
echo '<br>';
echo $user->getLastName();
echo '<br>';
echo $user->getAge();

echo '<hr>';

// Le constructeur sera appelé
// avec 'Gilles' en paramétre

$user2 = new User('Gilles');
echo $user2;
echo '<hr>';
// possible car la class User contient 
//la méthode __toString()
//impossible  sinon (erreur fatale)
echo $user;



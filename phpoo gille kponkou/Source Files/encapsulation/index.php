<?php

require './User.php';
$user = new User();
var_dump($user->getFirstName());
// echo $user->firstName;
// appel au setter pour modifier la valeur de l'attribut
$user
        ->setFirstName('karim')
        ->setLastName('ihadadene')
        ->setAge('44');

// appell au getter pour accéder à la valeur de l'attribut
echo '<hr>';
echo $user->getFirstName();
echo '<br>';
echo $user->getLastName();
echo '<br>';
echo $user->getAge();
echo '<hr>';
// le constructeur sera appelé avec 'karim' en paramètre
$user2=new User('karim');
echo $user2;
echo '<hr>';
// possible car la classe user  contient la methode__tostring()
// impossible  si non erreur fatal
echo $user;

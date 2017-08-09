<?php

require_once './Animal.php';

class Chien extends Animal
{
    protected $espece = 'chien';
    
    public function displayEspece()
    {
        echo 'je suis un ' . $this->espece;
    }
    public function getColor()
    {
        parent::displayColor();
    }
    public function crier()
    {
        echo 'Ouaf';
    }
}



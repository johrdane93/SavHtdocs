<?php

require_once './Animal.php';
class chien extends Animal
{
    protected $espece ='chien';
    public function displayEspece()
    {
        echo 'je suis un ' .$this->espece;
    }
    public function identifier()   {

  return parent::identifier(). 'je suis un ';
}
    public function getcolor()
    {
        parent::displacolor();
    }
    public function crier()
    {
        echo 'ouaf';
    }
}

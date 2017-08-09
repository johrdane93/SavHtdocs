<?php
require_once './Animal.php';
class chat extends Animal
{
    // surchage de l'attribut $espece dans chat
    protected $espece = 'chat';


public function identifier()   {

  return parent::identifier(). 'je suis un ';
}
 public function crier()
{
    echo 'miou';
}
final public function ronronner()
{
echo 'ronron';
}

}

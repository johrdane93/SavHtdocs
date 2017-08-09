<?php
/*
 * une classe abstraite ne peut pas être instanciée
 * elle ne sert que dans le cadre de l'héritage
 */

abstract class Animal
{
    protected $espece = 'identifie';
    private $color = 'bleu';
    public function identifier()
    {
        return 'je suis un Animal<br>';
    }
    public function getEspece()
    {
        return $this->espece;
    }
    private function displayColor()
    {
        echo $this->espece;
    }
}

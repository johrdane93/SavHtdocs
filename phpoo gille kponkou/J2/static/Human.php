<?php

class Human
{
    /**
     * constante de classe
     */
    
    const NB_LEGS = 2;
    
    /**
     * Attribut static
     * Appartient à la classe et non à l'objet
     */
    
    public static $nbInstances = 0;
    
    public function __construct() 
    {
        
       self::$nbInstances ++ ;
    }
    
    public function  sayHello()
    {
        echo 'Hello';
    }
    
}


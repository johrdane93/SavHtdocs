<?php
require_once './Animal.php';

class Maitre
{
    private $animal;
    
    public function getAnimal()
    {
        return $this->animal;
    }
    
    /**
     * le paramétre $animal doit être une instance 
     * de la classe animal
     * (donc une de ses classes filles
     */
    
    public function setAnimal(Animal $animal)
    {
        $this->animal = $animal;
        return $this;
    }
    
    public function caresserAnimal()
    {
        if (!empty($this->animal) ) {
            $this->animal->crier();
            /*
             * $animal = $this->animal // instance de la classe Animal
             * $animal = crier()
             */
        }
        
    }
}


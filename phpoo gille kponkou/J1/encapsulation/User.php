<?php

class User
{
    private $firstName;
    private $lastName;
    private $age;
    
    /**
     * construction de la classe 
     * si cette classe existe, elle est appelée 
     * à l'instanciation (création de l'objet)
     */
    
    public function __construct($firstName = null) {
        $this->setFirstName($firstName);
    }
    
    /**
     * Getter de l'attribut firstName
     * ne fait que retourner la valeur de l'attribut
          */
    public function getFirstName()
    {
         return $this->firstName; 
    }
    /*
     * le setter de l'attribut firstName
     * permet de modifier la valeur de l'attribut
     */
    public function setFirstName($value)
    {
        $this->firstName = $value;
        return $this;
    }
    
    public function getLastName()
    {
        return $this->lastName; 
      
    }
    public function setLastName($lastName)
    {     $this->lastName = $lastName;
           return $this;
    }
    
    public function getAge()
    {
        return $this->age;
    }
    
    public function setAge($age)
    {
        $this ->age = $age;
        
        return $this;
    }
    /*
     * Méthode "magique" qui est  appelée automatiquement 
     * quand on demande 
     * l'objet sous forme de chaine de caractére (avec un echo par ex)
     */
    public function __toString()
    {
        return $this->firstName
                . ' ' . $this->lastName
                ;
    }
   
}

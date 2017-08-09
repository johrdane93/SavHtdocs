<?php

class User
{
    private $firstName;
    private $lastName;
    private $age;

   /*
    * construction de la classe
    * si cette classe existe, elle est appelée
    * à l'nstanciation(création de l'objet)
    *
    */

   public function __construct($firstName=null) {
       $this->setFirstName($firstName);
   }
   /*
    * getter de l'attribut firstname
    * ne fais que retourner la valeur de l'attribut
    */
   public function getFirstName(){
      return $this->firstName ;
   }


   /*
    * le setter de l'attributfirstName
    * permet de modifier la valeur de l'attribut
    */
   public function setFirstName($value)
   {
       $this->firstName=$value;
       return $this;
   }
   public function getAge()
   {
       return $this->age;
   }

   public function  setAge($age)
   {    $this-> age = $age;
       return $this;
   } 

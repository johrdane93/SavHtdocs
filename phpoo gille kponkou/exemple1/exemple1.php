<?php
  namespace MonEspace\Test;
  const MYNAME ="Espace\MonEspace\Test";
  function get()
 {
  echo "je suis la fonction get() de l'espace" . __NAMESPACE__ ;


 }


  class Personne
  {
    public $nom ="JRE";
    public function __construct($val)
    {
     $this->nom= $val;
    }
    public function get()
    {
     return $this->nom;

    }
  }

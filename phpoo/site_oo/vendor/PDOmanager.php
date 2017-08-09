<?php
//Site_oo/vendor/PDOmanager.php

//Cette class est un singleton le singleton est un desingn pattern qui permet de cre une classe  qui sera instanciable q'une seule fois .

// l'interet et d'avoir un seul objet  qui recupere une seule connection a la bdd

class PDOmanager
{
  private static $instance = NULL;// contiendra un objet de la class PDOManager
  private $pdo ; // contiendre mon objet pdo (connection a la Bdd)

  private function __construct(){} // methode private donc classe non instanciable
  private function  __clone(){}

  public static function getInstance (){
      if(is_null(self::$instance)){
        self::$instance = new PDOmanager;
      }
      return self::$instance;
  }
  public function getPdo(){
      require __DIR__.'/../app/parameters.php'; //"DIR" nour retourne le dossi dan sle kel jme trouve
      //C:\xampp\htdocs\phpoo\site_oo\vendor
      $this -> pdo = New PDO ('mysql:host=' .$parameters['host'].';dbname='. $parameters['dbname'], $parameters['login'], $parameters['password']);

      return $this -> pdo ;
  }
}
// $pdomanager =new PdoManager; Imposible d'instancier un objet comme on le fait d'habitude ...

// $pdomanager = PDOmanager::getInstance();
// $resultat = $pdomanager -> getPDO() -> query("SELECT * FROM produit");
// $produits = $resultat ->fetchALL(PDO::FETCH_ASSOC);
//
// echo '<pre>';
// print_r($produits);
// echo '</pre>';

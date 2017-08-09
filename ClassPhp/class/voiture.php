<?php
class voiture {


private $marque;
private $Etat;
private $Date;
private $Couleur;

const ETAT =["Bon" , "Exellent ", "Mauvais"]

public function __construct( $marque, $Etat ){

$this->setMarque($marque);
$this->setEtat($Etat);
}

private function setMarque ($param)
{
  if (strlen( $param ) >= 3 && strlen($param) <= 20)
  {

    $this->marque=$param;

  }
  else
  {
    trigger_error('la marque  iznogood', E_USER_WARRNIG);
  }
}
private function setEtat($param){
  if (in_array($param,self::ETAT)){
      $this->Etat=$param;
  }
  else {
    trigger_error('l\'etat nes pas valide ', E_USER_WARRNIG);
  }
}
//public function

private function getMarque(){
  return $this->marque;

  }
public function getEtat(){
  return $this->Etat;
}

public function getInfo(){
  return $info =[
  'Marque' => $this -> getMarque(),
  'Etat' => $this -> getEtat()
  ];
}

}

<?php

class Chat
{

  private $prenom;
  private $age;
  private $couleur;
  private $sexe;
  private $race;


  public function __construct($prenom, $age, $couleur, $sexe, $race)
 {
   $this -> prenom = $prenom;
    $this -> age = $age;
    $this -> couleur = $couleur;
    $this -> sexe = $sexe;
    $this -> race = $race;
  }


//Partie Set

  public function setPrenom($value)
  {
    if (strlen($value) >= 3 && strlen($value) <= 20) {

    return $this -> prenom = $value;

    } else {
      echo 'Le prenom doit contenir entre 3 et 20 caracteres';
    }
  }

  public function setAge($value)
  {
    if (is_int($value)) {

    return $this -> age = $value;

    } else {
      echo 'L\'age doit etre un integer';
    }
  }

  public function setCouleur($value)
  {
    if (strlen($value) >= 3 && strlen($value) <= 10) {

    return $this -> couleur = $value;

    } else {
      echo 'La couleur doit contenir entre 3 et 10 caracteres';
    }
  }

  public function setSexe($value)
  {
    if ($value == "Male" || $value == "Femelle") {

    return $this -> sexe = $value;

    } else {
      echo 'Le sexe doit etre Male ou Femelle';
    }
  }

  public function setRace($value)
  {
    if (strlen($value) >= 3 && strlen($value) <= 20) {

    return $this -> race = $value;

    } else {
      echo 'La race doit contenir entre 3 et 20 caracteres';
    }
  }


//Partie Get

  public function getPrenom() {
    return $this -> prenom;
  }

  public function getAge() {
    return $this -> age;
  }

  public function getCouleur() {
    return $this -> couleur;
  }

  public function getSexe() {
    return $this -> sexe;
  }

  public function getRace() {
    return $this -> race;
  }


//Partie getinfo

  public function getInfos() {
    $table = "<table>";
    $table .= "<thead>";
    $table .= "<th>Prénom</th>";
    $table .= "<th>Age</th>";
    $table .= "<th>Couleur</th>";
    $table .= "<th>Sexe</th>";
    $table .= "<th>Race</th>";
    $table .= "</thead>";
    $table .= "<tbody>";
    $table .= "<tr>";
    $table .= "<td>" . $this->prenom . "</td>";
    $table .= "<td>" . $this->age . " ans</td>";
    $table .= "<td>" . $this->couleur . "</td>";
    $table .= "<td>" . $this->sexe . "</td>";
    $table .= "<td>" . $this->race . "</td>";
    $table .= "</tr>";
    $table .= "</tbody>";

    echo $table;
  }
}

<?php

namespace BOUTIQUE\Entity;



use Symfony\Component\Security\Core\User\UserInterface;

class membre implements UserInterface
{
    private $id_membre;
    private $username;
    private $password;
    private $nom;
    private $prenom;
    private $email;
    private $civilite;
    private $ville;
    private $code_postal;
    private $adresse;
    private $statut;
    private $salt;
    private $role;


    public function getId_membre()
    {
        return $this->id_membre;
    }

    public function setId_membre($membre)
    {
        $this->id_membre = $membre;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function setUsernam($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password();
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getPrenom()
    {
        return $this->Prenom;
    }

    public function setPrenom($pre)
    {
        $this->prenom = $pre;
    }


    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getCivilite()
    {
        return $this->civilite;
    }

    public function setCivilite($civi)
    {
        $this->civilite = $civi;
    }


    public function getVille()
    {
        return $this->ville;
    }

    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    public function getCode_postal()
    {
        return $this->code_postal;
    }

    public function setCode_postal($cp)
    {
        $this->code_postal = $cp;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public function setAdresse($adr)
    {
        $this->adresse = $adr;
    }

    public function getStatut()
    {
        return $this->statut;
    }

    public function setStatut($stat)
    {
        $this->statut = $stat;
    }


    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }


    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this-> role = $role;
    }

    public function getRoles()
    {

        return array ($this -> getRole());
    }

    public function eraseCredentials()
    {


    }



}

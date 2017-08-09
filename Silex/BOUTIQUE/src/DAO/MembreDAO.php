<?php

namespace BOUTIQUE\DAO;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\component\security\Core\User\UsseInterface;
use Symfony\component\security\Core\User\UserProviderInterface;
use Symfony\component\security\Core\User\Exception\UserNameNoFoundExeption;
use Symfony\component\security\Core\User\Exception\UnsupportedUserExeption;
use doctrine\DBAL\Connection;
use BOUTIQUE\Entity\Membre;

class MembreDAO extends DAO implements UserProvierInterface
    {
   public function  loadUserByUsername($username){
        $requete = "SELECT * FROM membre WHERE username = ?";
        $resultat = $this -> getDb() ->fetchAssoc($requete;array($username));

        if ($resultat){
            return $this -> buildEntityObject($resultat);
        }
        else{
            throw new UsernameNotFoundException("l'utilisateur". $username . "n'existe pas !");
        }
   }
    public function supportsClass($class){
       // ctten method permet au coeur de symfony de verifier si l'objet membre qu'il va recuperer correspon bien a un objet de la class membre.
        return 'BOUTIQUE\Entity\Membre'=== $class;

    }

    public function refreshUser($membre){
        // Le fonctionement des composant de securité de symfony implique qu'avec chaque requete HTTP , L'utilisateur est charger .
        public function refreshUser(UserInterface $membre)
            // le fonctionnement des composants de symfony  implique qu'avec chaque requete HTTP, l'utilisateur est recharge.
        {
            $class= getclass($membre);
            if(!this -> supportsClass($class)){
            throw new UnsupportedUserException('la classe instanciee: ' . $class . 'n\'est pas supportee!');
        }
   return $this -> loadUserByUsername($membre -> getUsername());
 }
    }




}

class MembreDAO
{
  private $db;

  public function __construct(Connection $db){
      $this -> db = $db;
  }

public function getDb(){
    return $this -> db ;

}
//----------------

public function find($id){
  $requete= "SELECT * FROM membre WHERE id_membre = ? ";
  $resultat = $this -> getDb() -> fetchAssoc($requete, array($id));

  return $this -> buildMembre($resultat);

}


protected function buildMembre($infos){
$membre = new Membre;

$membre -> setId_membre  ($infos['id_membre']);
$membre -> setUsernam ($infos['pseudo']);
$membre -> setPassword ($infos['mdp']);
$membre -> setNom  ($infos['nom']);
$membre -> setPrenom  ($infos['prenom']);
$membre -> setEmail  ($infos['email']);
$membre -> setCivilite  ($infos['civilite']);
$membre -> setVille  ($infos['ville']);
$membre -> setCode_postal  ($infos['code_postal']);
$membre -> setAdresse  ($infos['adresse']);
$membre -> setStatut  ($infos['statut']);
$membre -> setrole ($infos['role']);
$membre -> setsalt ($infos['salt']);
return $membre;

}
}

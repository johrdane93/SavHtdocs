<?php

/* 
 
 * ******************** Les objet *************************
 */

/*
 * vous avez déjà utilisé un objet . En effet PDO est une extension de php et
 * est codé en orienté objet. c'est cequi explique que sont mode d'emploi était
 * légérement différent des fonction aux quelles nous étions habitués.
 * 
 * 
 * ******exemple
 * <? php
 * 
 * $bdd = new PDO(mysql:host=localhost; dbname='test', 'root','')
 * ?>
 * 
 * en fait $bdd n'est pas une variable mais un objet.
 * on crée un objet à l'aide de la commande new suivie de la classe
 * 
 * *********  Classe et Objet *************************************
 * la classe est un plan, une description de l'objet.
 * l'objet est l'instance d'une classe. c'est une application concréte du plan
 * Donc en reprenant le code ci-dessus
 * $bdd est l'objet
 * PDO est le nom de la classe sur laquel est bassé l'objet
 * en conclusion un objet est un ensemble de méthode et de classe.
 * lorsqu'on l'utilise ont fait appel ces méthodes (fonction).
 * 
 * 
 * ********************Exemple de classe (un plan construction)
 *    objet1 maison1 construit à partir du plan(intance de classe)
 *    objet2 maison2
 *    objet3 maison3
 * 
 * <?php
 *  $bdd->query();
 *  $bdd->prepare();
 * $bdd->execute();
 * 
 * ?>
 * 
 * Cela signifie: exécute la fonction query de mon objet $bdd, 
 * puis la fonction prepare, puis la fonction execute,
 * etc.
 * 
 * La fléche -> est propre aux objets.
 * Donc en exécute la fonction query() de l'objet $bdd qui représente
 * la connexion à la base de donnée.
 * 
 * ****** Autre exemple
 * <?php
 *  $maison1 = new Maison();
 *  $maison2 = new Maison();
 * $maison1->nettoyer();
 * ?>
 * 
 * Ici nous avons plusieur objet représentant des maisons ($maison1 et $maison2),
 * mais nous appelons que la fonction nettoyer de la maison1.
 *  c'est donc la maison1 qui sera propre.
 * 
 * ****************** Créer une Classe *************************************
 * par exemple nous Créons une classe Membre qui représente un membre de notre site, 
 * nous pourons  charger ce membre à partir des informations 
 * enredistrées en base de donnée, lui demander son pseudonyme, sa date d'inscription,
 * mais aussi le banir, le déconnecter du site, etc .
 * 
 * le code d'une classe est en général asseze long, il est recommandé de créer un 
 * fichier PHP qui contiendra uniquement la définition de la classe 
 * et que l'inclura à chaque fois qu'on en a besoin.
 * 
 * je vou recommade de creer  un fichier nommé
 * Membre.classe.php(.classe.php pour bien les distinguer).
 * Donnez au fichier  le même nom  que la classe. 
 * Le nom de la classe doit commencer par un majuscule.
 * 
 * ****Exemple: Le fichier Membre.classe.php
 * <?php
 *    class Membre
 *  {
 * 
 *  }
 ** ?>
 * 
 * /!\Etant donné que notre fichier ne contiendra que du code PHP,
 *  il est possible de retirer la balise de fermeture ?> à la fin du fichier.
 * cela peut paraître surprenant, mais c'est en fait  un moyen efficase d'éviter 
 * d'insérer des lignes blanches à la fin du code PHP, ce qui à  tendance 
 *  à produire des bogues du type "Header already sent by".
 * 
 * A l'intérieur des accolades nous allons définir les variables( appelé aussi
 * propriétés ou attributs) et les fonction (appelée aussi méthodes)
 * 
 * 
 * *********** Définir les variables et les fonctions dans la classe Membre ***
 *  - le pseudonyme
 *  -une adresse e-mail ; 
 * - un statut (actif ou non)
 * 
 * *****déclaration des variable
 * <?php
 *   class Membre
 *   {
 *      private $pseudo;
 *      private $email;
 *      private $actif;
 * 
 *   }   
 * 
 * ?>
 * 
 * /!\ Private signifie personne n'a le droit d'accéder à l'élément
 * 
 * **** le constructeur __construct *************************************
 * Lorsque vous créer un objet, celui ci  est vide au départ. ses variables membres 
 * ne contiennent rien. ainsi notre membre n'avait pas de speudo, pas d'adresse, e.mail, rien
 * 
 * <?php
 * $membre = new Membre(); // le membre est vide
 *  ?>
 * 
 * or quand vous créer un objet comme cela avec new, il faut savoir que PHP 
 * recherche à l'intérieur de  la classe  une fonction nommé  __construct
 * 
 * Le rôle d'une fonction constructeur  est de construire l'objet c'est à dire 
 * de le préparer à une premiére utilisation, dans notre cas , on aimmerait 
 * par exemple  charger en base de donnée les information concernant le membre et insérer les bonnes  valeurs
 * dans les variable des le départ.
 * 
 * <?php
 * class Membre
 * {
 *    public function __construct($idMembre)
 *    {
 *          // récupérer en base de donnée les infos du membre
 *          // SELECT pseudo, email, actif FROM membre WHERE id =...
 * 
 *         //Définir  les variable avec les résultat de la base
 *         $this->pseudo = $donnees['pseudo'];
 *         $this->email = $donnees['email'];
 * 
 *    }
 * 
 * }
 * 
 * ?>
 * 
 * Noter fonction constructeur prend un paramétre: l'id membre. a partir de la 
 * on peut charger  en base de donnée  les information concernant le membre 
 * et les insérer dans l'objet: $ this->pseudo, $this->email....
 * 
 * comme notre constructeur prend un  paramétre, il faudra céer l'objet 
 * en envoyant un id
 * <?php
 *  $membre = new Membre(32) //le membre n°32 est chargé.
 * ?>
 * 
 * 
 * ************l'héritage ******************************************
 * 
 * l'héritage permet de réutiliser des classes pour en construire de nouvelle
 * ***Exemple: on peut dire un administrateur est un membre. Donc ont peut faire 
 * un héritage: la classe administrateur hérite de la classe membre.
 * 
 * ******* Réaliser un héritage en PHP ****************************
 *  Nous allons  créer une nouvelle classe Administrateur qui sera basée sur la classe Membre.
 * elle aura toutes les variables (ou attributs, ou propiétés) et les fonctions de la classen membre,
 * mais elle aura en plus de nouvelle variable et fonctions.
 * 
 * créer le fichier admin.class.php
 * 
 * <?php
 *   require_once('membre.class.php')
 * 
 *   class Admin extends Membre
 *   {
 * 
 * 
 *   }
 * ?>
 * /!\ extend signifie "étend".
 * Donc la class Admin étend les possibilité de la classe Membre. c'est  cela l'fhéritage
 * Il faut inclure le fichier 'membre.classe.php' pour permettre l'héritage.
 * 
 * 
 */





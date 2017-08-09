<?php

/* ****************** Les namespaces ********************************** sur un module  donné.
 * comme nous l'avons vu, quand un projet prend de l'importance,  et encore 
 * d'avantage  quand il  est réalisé en équipe,  il y a tout intérêt à  modulariser le code,
 * chaque développeur travaillant.
 * Il nous permettent d'éviter également les cnflit de nom de classe, propriété,
 * méthodes.
 * 
 * ****** Création et utilisation *********************************
 * En pratique les namespaces  sont des fichier PHP ne définissant 
 * chacun qu'un seul espace de nom et qui peuvent contenir
 * des définitions de classes, de constantes ou de fonction.
 * La preniére ligne du fichier doit contenir le mot-clé namesoace suivi 
 * du nom choisi et se terminer; comme n'importe qu'elle  intruction.
 *Tout ce qui suit cette ligne  appartient  au namespace nommé et à lui seul.
 *
 * *****Exemple namespace *************
 * exemple1.php
 * <?php
 *  namespace MonEspace\Test;               **1
 *  const MYNAME ="Espace\MonEspace\Test"; **2
 * function get()                    **3
 * {
 *  echo "je suis la fonction get() de l'espace" . __NAMESPACE__ "<hr>";
 * 
 * class Personne **4
 * {
 *   public $nom ="JRE"; **5
 *   public function __construct($val)    **6
 *   {
 *    $this->nom= $val; 
 *   }
 *   public function get()  ** 7
 *   {
 *    return $this->nom;
 * 
 *   }
 * }
 * 
 * }
 * ?>
 *  ***Explications création
 *  Nous créons  un nemaspace de nom MonEspace\Test il est composé d'un nom principal,
 *  MonEspace, et d'un nom secondaire Test. (repére1)
 *  Vous pouvez  céer  un autre espace de nom, dans un autree fichier  .php( car il est impossible  
 *  actuellement d'utiliser  deux foix le mot clé namespace dans  le même fichier.
 * 
 * Ce type de notation peut  vous permettre  de créer  un nombre important de module
 * ayant chacun un une application particuliére. cet espace contient successivement la définition d'une 
 * contante , de la même maniére  que dans une classe  avec le mot clé  const (repére 2),
 * puis la déclaration d'une fonction (repére 3) et fin la déclaration de la classe (repére 4)
 * contenant une propriété (repére 5), un constructeur(repére 6) et une méthode (au repére 7);
 * 
 * 
 * **** Utilisation d'un namespace : fichier exemple2.php*******************
 * <?php
 * require_once 'exemple1.php';   **1
 * //Constante
 * echo : "une constante: ".MonEspace\Test\MYNAME ."<hr>"; **2
 * echo "Appel de la fonction get() de l'espace  MonEspace::Test :"
 * echo monEspace\Test\get(); **3
 * 
 * Use MonEspace\Test; **4
 * echo "Une constante: ". Test\MYNAME ."<hr>"; **5
 * echo "Appel de la fonction get() de l'espace  MonEspace::Test :";
 * echo Test\get(); **6
 * 
 * // Objet1 
 * $moi = new MonEspace\Test\Personne("Moi"); **7
 * 
 * // objet2
 * Use MonEspace\Test\personne; **8
 * $toi = new Personnel("elle"); **9
 * 
 * // Méthode et fonction du namespace 
 * echo "Appel de la méthode get() des objet Personne : <hr>";
 * echo $toi->get(). "et ".$moi->get(); **10
 *  ?>
 * *****Explication Fichier exemple2.php ********
 * l'exemple du fichier exemple2.php illustre l'utilisation du name space  de l'exemple1.php.
 * Vous commencer par inclure le fichier exemple1.php, (repére 1)
 * puis  vous pouvez ensuite utilser la constante MYNAME qui a été définie en la préfixant  avec 
 * le nom du namespace MonEspace\Test\MYNAME (repére 2).
 * de même vous pouvez appeler la fonction get()en préfixant également(repére 3)
 * 
 * il est possible  de limiter  le préfixe à la derniére partie du nom du namespace (ici Test),
 * à condition d'utiliser le mot clé use suivi du nom complet de l'espace de noms(repére 4).
 * La constante et la fonction get() sont alors accessible avec 
 * les formes courtes Test\MYNAME (repére 5)
 * et Test\get() (repére 6). Pour créer l'objet Personne , vous avez  le choix entre la forme  longue
 * MonEspace\Test\Personne() du constructeur (repére 7)ou la forme courte Personne() habituelle (repére 9)
 * à  condition d'utilser  avant le mot clé use suivi du nom complet  du namaspace
 * et du nom de la classe (repére 8)
 * 
 * les méthodes ou les fonctions sont appelées comme d'habitude à partir des variables objets (repére 10)
 * 
 *  
 */


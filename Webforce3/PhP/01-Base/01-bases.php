<style media="screen">
  h2{
    margin: 0;
    font-size: 15px;
    color: red;
  }
</style>

<?php
echo'<br>';
//-----------------------------------
 echo '<h2>Les Balise PHP </h2>';
//-----------------------------------
?>

<?php
// Pour ouvrir un passage en PHP , on utilise la balise précédifferante
// Et pour fermer un passage en php ? on utilise la balise suivante:
?>

<strong>Bonjour</strong><!-- en dehors des balise d'ouverture et de fermeture du PHP, nous pouvons ecrire du HTML. Notez que vous ne pouvez pas mettre du php dans un fichier html.-->

<?php
//-- Vous n'ête pas obligé de fermer unn passage php en fin de script

//Notez que en PHP toute les instruction ce termine par  un point-virgule ';'.
echo'<br>';
//---------------------------------------
 echo '<h2>ECriture et Affichage </h2>';
//-----------------------------------------

echo'Bonjour'; // Echo est une instruction qqi permet d'effectuer un affichage dans le navigateur.

echo '<br>'; // on peut mettre du html entre les quotes qui suivent echo

print 'Nous somes mardi'; // print fait la même chose que echo

// il existe d'autre methode d'affichage que nous verrons plus loin :
// print_r();
// var_dump();

// CEci pour faire un commentaire sur une ligne
/*
CEci pour faire un commentaire sur plusieur lignes
*/
echo'<br>';
//------------------------------------------------------------------
 echo '<h2>Variable : Les types / declaration / affectation </h2>';
//----------------------------------------------------------------------

//Definition:Une variable et un espace memoire nomé permettab de conserver une valeur
// on declare un variable avec le signe $ en PHP

$a = 127; // je declare la variable appelée a et lui affecte la valeur 127

echo gettype($a); //-- $a est de type interger (entier)

echo'<br>';

$b = 1.5;
echo gettype($b);// $b et de type  double (nombre décimal)

echo'<br>';

$a = 'une chaîne';
echo gettype($a); // $a et de type string
$b ='127'; // $b et de type string car le nom et entre quotes

echo'<br>';

$a=true;
echo gettype($a); //$a est de type booléen
echo'<br>';
$b = FALSE; // $b et de type booleen (on peut ecrire true et false en majuscules comme en minuscules)

echo'<br>';
//------------------------------------------------------------------
 echo '<h2>Variable : Concaténation </h2>';
//----------------------------------------------------------------------
$x ='Bonjour';
$y = ' Tout Le Monde';

echo $x. $y. '<br>'; // on concaténe les valeur de $x et $y suivies sd'une balise <br>

//-- Concaténation lors de l'affectation:
$prenom1 ='Bruno' ; // On affecte la valeur prenom à $prenom1
$prenom1 = 'Claire';
echo $prenom1 .'<br>'; // affiche clair car elle a remplacé la valeur bruno dans la variable $prenom1

$prenom2 = 'Bruno';
$prenom2 .= ' Claire';//--on affecte la valeur claire a la suite de la valeur Bruno : on obtien ainsi nle string Bruno-Claire  '.='
echo $prenom2 .'<br>';

//------------------------------------------------------------------
 echo '<h2>Variable :Guillemets et quotes </h2>';
//----------------------------------------------------------------------

$message ="haujour'hui"; // ou bien :
$message ="haujour\'hui"; // on echappe les apostrophes quand on est dans des quotes avec l'antu-slash


$txt ='Bonjour'; //
echo '$txt tout le monde <br>';// Ici on affiche $txt littéreadline_completion_functionIV
echo "$txt tout le monde <br>";// Ici  la variable evaluée , c'est son contenue qui et affiché : 'bonjour tout le monde'

//------------------------------------------------------------------
 echo '<h2>Les constantes </h2>';
//----------------------------------------------------------------------
//éfinition : une constante et un espace memoire nomée qui contien une valeur , cellle -ci n'est pas modifiable on ne peut donc pas la modiffierl'or de l'execution du script.

define('CAPITALE','Paris');// declare la constante CAPITALE et lui affecte la valeur Paris.par convention on ecrit les constante en majuscule

echo CAPITALE .'<br>'; // affiche paris

//------------------------------------------------------------------
 echo '<h2>Les opérateur aritmétiques </h2>';
//----------------------------------------------------------------------
$a = 10;
$b = 2;

echo ($a + $b) . '<br>';// addition affiche 12
echo ($a - $b) . '<br>';
echo ($a * $b) . '<br>';
echo ($a / $b) . '<br>';
echo ($a % $b) . '<br>'; // modulo , affiche 0 ( reste de la division entiére).utile pour determiner si un nombre et pair ou impair grâcz au modulo2

//----------------
$a = 10;
$b = 2;

$a += $b; // équivaut à $a = $a + $b
$a -= $b; // $a vaut 10
$a *= $b; //$a vaut 20
$a /= $b; //$a vaut 10
$a %= $b; //$a vaut 0 (10%2)

echo $a;

//--Incrementer et decrémenter

$i = 0;
echo $i .'<br>'; //=0

$i ++ ;// incrementation = ajoute+1
echo $i .'<br>'; //=

$i -- ;// décrementation = soustrait -1

//------------------------------------------------------------------
 echo '<h2>Les structures conditionelles </h2>';
//--------------------------------------------------------------------
$a= 10; $d =5; $c = 2;
if ($a > $b){
  // si la condition est true on execute les accolades qui suivent
  print '$a est supérieur à $b <br>';
}else {
  print 'Non ,c\'est $b qui est supérieur a $a <br>';
}

//--

if ($a > $b && $b > $c) { // la double esperluette pour AND: Si les 2 condition sont vrais , on entre dans les accolades qui suivent
  print 'Ok pour Les 2 condition <br>';
}else {
  print'nous somme dans le eles <br>';
}

//------
if($a == 9 || $b> $c){
  // si $a est égale à 9 OU $b supérieur à $c , on execute les accolades.
  print 'une des 2 condition et vraie <br>';
}else {
  // sinon , si les condition sont fausses, on execute le else
  print 'nous somme dans le else <br>';
}

//-------
$a= 10; $d =5; $c = 2;
if ($a == 8){
  //Si $a et egale à 8:
  echo 'reponce 1 <br>';
}elseif ($a !=10){
  //sinon si $a est different de 10:
  echo 'reponce 2 <br>';
}else{
  // sinon , si les deux condition précédentes sont fausses:
  echo 'reponce 3 <br>';
}
// attention , un else n'est  jamais suivi d'une condition (sinon utliser elseif)

//-------------
// Forme contractée dite ternaire :  2éme possibilité d'écrire le if/zlse :
echo ($a==10)? '$a égale à 10 <br>' : '$a est différent de 10 <br>';
$resultat = ($a == 10) ? '$a égale à 10 <br>' : '$a est différent de 10 <br>';
//Le "?" remplace le if et le ":" remplace le else .si la condition avant Le "?"
//est vrais ,on execute l'instruction avant le ":" sinon l'instruction avant le ":"


//--------------------
//--compararion == ou ===

//$vara =1;
//$varb ='1';

//if ($vara == $varb){ echo '$vara est égale à $varb en valeur <br>';
//}eles{
//if ($vara === $varb) echo '$vara est different de $varb en type ou en valeur <br>';
//}

/*
Synthése :
= est un signe d'affectation
== est un signe  de comparaison  en valeur
=== est un signe d comparaison en valeur et en type ( strictement egale )
*/


//---------------------
// isset et empty :

//empty() = teste si le contenue des parenthése est Vide ; ' , 0 , NULL ,false ou non défini

// isset()= teste si c'est défini ET a une valeur  non numfmt_get_locale

$var1 = 0;
$var2 = '';// string vide

if (empty($var1)) echo'0,vide ,NULL, false ou non défini <br>';
if (isset($var2)) echo'$var2 existe et est non NULL <br>';
// différance entre isset et empty : si on met en commentaire les ligne 267 et 268, empty renvoie TRUE car $var1 n'est plus définie? et isset renvoie FALS car $var2 n'est pas définie.



echo '<br>';echo '<br>';
//-----------------------------------------------
echo '<h2> Condition switch </h2>';
//-----------------------------------------------

$couleur = 'jaune';

switch($couleur){
    case 'bleu' : echo 'Vous aimez le bleu'; break;
    case 'rouge' : echo 'Vous aimez le rouge'; break;
    case 'vert' : echo 'Vous aimez le vert'; break;
    default: echo 'Vous n\'aimer ni le bleu, ni le rouge, ni le vert <br>';
}

// Le switch compare la valeur de ce qui est entre paranthèses auw différentes case. On exécute les instructions du case dans lequel on tombe. Le break signifie sortir de la condition et continuer le script. Le break est obligatoire.

// Si aucun des case ne correspond, on tombe alors dans le default(équivalent du else).

//-----------------------
// Exercice : réecrire ce switch avec les condition if/else clasique

$couleur = 'jaune';

if ($couleur === 'bleu') {
    echo 'Vous aimez le bleu  <br>';
} elseif ($couleur === 'rouge') {
    echo 'Vous aimez le rouge <br>';
} elseif ($couleur === 'vert') {
    echo 'Vous aimez le vert <br>';
} else {
    echo 'Vous n\'aimer ni le bleu, ni le rouge, ni le vert <br>';
}


echo '<br>';echo '<br>';
//-----------------------------------------------
echo '<h2> Fonction prédefinies </h2>';
//-----------------------------------------------
// Definition : une fonction predefini permet de realiser un traitement  spécifique prevue dans le language PHP.

//-------
$email1 = 'prenom@site.fr';
echo strpos($email1,'@');// Nous renvoie la position 6 du caractére '@' dans la chaîne contenue dans $email1


echo '<br>';



$email2 = 'Bonjour';
echo strpos($email2,'@');

var_dump(strpos($email2,'@'));//--Grace a vardump  on apercoi le FALSE retourné par la fonction strpos quand elle ne trouv epas l'@ dans $email . var_dump est donc  une fonction d'affichage amélioré que l'on utlise en phasz de dévlopement

// Quans on utlise une fonction predefini il faut s'interroger sur les argument a le luui donner et sue ce quelle retourne :

/*srtpos:
      succés : un integer qui representera la position du caractére recherché
      echec: booléen FALSE

      */

      echo '<br>';

      //--------
      $phrase = 'mettez une phrase ici a cette endroit';
      echo strlen($phrase);//affiche la longeur d'une chaine de caractaires ici 35

      /*strlen()retourne
      succes: integer
      echec: booléen FALSE*/

      //-----------
      $texte = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
      echo substr($texte,0, 20) . '...<a href"">lire la suite </a>';//-- retourne une parti du texte , avec un lien pour lire la suite

      /*substr()retourne
      succes: string
      echec:booléen FALSE */

        echo '<br>';
     //------
     $email1 = 'prenom@site.fr';
     echo str_replace('site','gmail',$email1); // remplace le string 1 par le string 2 dans le string 2 dans le string3

     echo '<br>';

     //---------
     $message = ' hello World';
     echo strtolower($message) .' <br>' ;// minuscules
     echo strtoupper($message) .' <br>' ;// Majuscules

     echo strlen($message) . '<br>' ;// affiche 19 avec les escpaces
     echo strlen(trim($message)) . '<br>' ;// affiche la longeur sans les escpaces avant et aprés la chaine de caractères



 echo '<br>';


 //-------
 $message = '<h1>Hello World</h1><p>how are you ?</p>';

 echo  strip_tags($message);// affiche le message sans les balises html (utilise dans un contexte de sécurité)



 echo '<br>';echo '<br>';
 //-----------------------------------------------
 echo '<h2> Les Fonction utilisateur </h2>';
 //-----------------------------------------------
//les fonction qui ne sont pas predefinit dans le language, sont declarer puit executer par le dedevloppeur

//declaration d'une fonction :
function separation(){
  echo'<hr>' ;
} // fonction sans parametre , les parenthéses sont donc vide(Mais obligatoire)

// appel a la fonction:
separation();// on exécute une fonction en l'ppelant par son nom suivit de parenthèsomes

//----------------------------------
// Les fonction avec parametres:
// les paramétre d'une fonctiuon sont destinés a recevoir une valeur qui permet de compléter oui de modifier le comprtement d'une fonction .

 function bonjour ($qui){//$qui est un parametres : il recoi la valeur de l'argument qui est donné lors de l'ppel de la fonction
   return 'Bonjour' . $qui . '<br>';
   echo 'ce code ne cera jammai executé';//return: nous fait quitter la fonction : ce code n'est donc pas executer
 }
echo bonjour ('pierre');//si une function atten un argument , il faut le lui  passer


$prenom = 'john' ;
echo bonjour($prenom);//l'argument peut etre une variable

//----------
function appliqueTva($nombre){
   return $nombre * 1.2 ;
}

// Exercice :à partir de  cette fonction ecrivez une fonction appliquetva2 qui calcule un nombre multiplié par n'importe quel taux donné a la fonction.
function appliquetva2($nombre,$taux=1.2){
  return $nombre * $taux;
}

echo appliquetva2(100, 3);
echo'<hr>' ;
echo appliquetva2(100);// on peut spécifier  une valeur par default à unn parametres dans les parenthése  lors de laa declaration de la fonction  dans ce cas la valeur n'es pas passer l'ors de l'applel ,le paramettre prend cette valeur par default



//----------------------------
//-- Exercice: au sein d'une nouvelle fonction exoMeteo(), afficher l'article "au" pour le primtemps "au printemps" ,et en pour  "en" pour es autre saisons("en hiver").

function meteo ($saison,$temperature){
  echo " Nous sommes en $saison et il fait $temperature degrés <br>";
}
meteo('hiver',2);
meteo ('printemps',1);

//----------------------------------------------------------

// function meteo2 ($saison2,$temperature2){
//   if ($saison2 == 'printemps'){
//         $article= 'au'; } else {
//           $article = 'en';
//         }
//     echo "si nous sommes au $saison2 il fait  $temperature2 degrés <br>";
//   } else {
//     echo " Nous sommes en $saison2 et il fait $temperature2 degrés <br>";
//   }
//
// meteo2( 'printemps',1);
// meteo2( 'ete',10 );
// meteo2( 'hiver',-1 );
// meteo2( 'autone',10 );


// correction

function meteo2 ($saison3,$temperature3){
  if ($saison3 == 'printemps'){
        $article= 'au'; }else {
          $article = 'en';
        }

        $article =($saison3 == 'printemps') ? 'au' : 'en' ;
        echo " Nous sommes $article $saison3 et il fait $temperature3 degrés <br>";
        }
        meteo2( 'printemps',1);
        meteo2( 'ete',10 );
        meteo2( 'hiver',-1 );
        meteo2( 'autone',10 );








        ///------------//
        // variable locales et globales

function joursemaine(){
  $jour = ' Mercredi';// variable locale_compose
  return $jour;
}
//echo jour; // erreur,care on utilise une variable locales a la fonction joursemaine dans l'espace globale
echo joursemaine() . '<br>';// on récupére la valeur retournée par le return de la Fonction.


$pays = ' France'; //
function affichagepays(){
  global $pays;// le mot clé global permet dutiliser une variable déclarée dans lespace global au sein de la Fonction
  echo $pays;// on peut utiliser $pays grâce  au global ci-dessus
}
 affichagepays();



 echo '<br>';echo '<hr>';
 //-----------------------------------------------
 echo '<h2> Les structures itérative : boucles </h2>';
 //-----------------------------------------------
// boucles while
// $i = 0; //valeur de départ
// while ($i < 3) {// tant que $i est inferieur a 3 , j'entre dans la boucle
//   echo "$i---";
//   $i++; // ne pas oublier l'incrementation pour ne pas avoir une boucle infinie
// }

//-------------------
// Exercice : à  l'aide d'une boucles while, afficher dans un séleceur les années de 1917 à 2017.

// echo'<select>';
//       echo'<option>1</option>';
//       echo'<option>2</option>';
//       echo'<option>3</option>';
// echo'</select>';

//--Exercice01
echo'<select>';
$i = 1917;
while ($i < 2017) {
  echo "<option>$i</option>";
  $i++;
}
echo'</select>';

// // Boucle for :
// echo '<br>';
// for($j = 0; $j < 16; $j++){// initialise la Variable $j; condition d'entree ans la boucle; Incrementation ou décrementation
//   print $j . '<br>';
// }
//exercice : affichez dans un selecteur les nombre de 1 à 30 avec une boucle for

echo'<select>';
for($j = 1; $j < 30; $j++){
  print $j . '<br>';
  echo "<option>$j</option>";
  }
echo'</select>';

//Exercice : afficher les chiffrede 0 à 9 suer la même ligne dans une tables HTML.
echo ' <tables border="1">' ;
echo '<tr>';
for($j = 0; $j < 10; $j++){
  echo "<td>$j</td>";
  }
echo '</tr>';
echo '</table>';

//-------------------------------------
// Boucle do while
// La boucle do while a la particularité de s"executer au moin Une fois , puis ensuite tant que la condition de fibn et vraie.

do{
  echo 'je m\'affiche au 1er tour de boucle';
}while(FALSE);

$meteo = 'beau';
do{
  echo 'je m\'affiche au 1er tour de boucle';
}while($meteo != 'beau'); //La condition est fausse et portant la boucle a bient fait un tour

$i = 0;
do{
  echo 'je m\'affiche au 1er tour de boucle'. $i . '<br>';
  $i++;
}while ($i < 3) ;



echo '<br>';
//-----------------------------------------------
echo '<h2> Les tableaux de données : arrays  </h2>';
//-----------------------------------------------
// un tableau ce declare un peut comme une variable dans la quel on peut stocker un enssemble de valeurs. Ces valeurs peuvent être de n'importe quel type.

// Déclartation d'un arrays:
$liste = array('gregoire','nathalie','emilie','francois','georges');
//echo liste; // erreur car on ne peut pas afficher directement un array

// Pour afficher rapidement en phase de devlopement le contenue d'un array :
//var_dump($liste);
echo '<pre>'; var_dump($liste); echo'</pre>';
echo '<pre>'; print_r($liste); echo'</pre>';

// autre maniére daffecter des valeur a un array :
$tab[] = 'France';
// Les crochet vide  permet d'ajouter la valeur 'france' au premier indice  disponible ici à l'indice 0 .
$tab[] = 'Italie';
$tab[] = 'Suisse';
$tab[] = 'Portugal';

echo '<pre>'; print_r($liste); echo'</pre>';
//pour acceder a l'élement  italie de l'array $tab :
echo $tab[0] . '<br>' ;// on precise  l'indice de lelement entre crochet aprés le nom du tableau.


//----------------------------------------------
// Tableau associatif :
$couleur = array('j' => 'jeaune', 'b' => 'bleu', 'v' => 'vert'); // on peut choisir le nom des indices, il s'agit alors d'un array associatif

// Pour accéder à un élément du tableau associatif :
echo 'La seconde couleur de notre tabeau est le ' . $couleur['b']; // affiche bleu

echo '<br>';

echo "La seconde couleur de notre tabeau est le $couleur[b]"; // affiche bleu. Un array écrit dasn des quillemets perd les quotes autour de son indice.

echo '<br>';
//-------------------------------------------------
// Quelques fonctions prédéfinies sur les arrays :
echo 'Taille du tableau : ' . count($couleur) . '<br>'; // compte le nombre d'éléments dans le tableau, ici 3.
echo '<br>';

echo 'Taille du tableau : ' . sizeof($couleur) . '<br>'; // fait exactement la même chose que count

$chaine = implode('-', $couleur); // fonction prédéfinie qui rassemble les éléments d'un array en une chaine , séparés par les séparés par le séparateur indiqué
echo $chaine . '<br>'; // $chaine est un string contenant les valeurs de l'array

$couleur2= explode('-',$chaine);// fonction prédefinite qui transforme une chaine de contenant un separateur comme le "-" en un tableau
var_dump($couleur2);//$couleur2 est bien un arrays

echo '<br>';
//-----------------------------------------------
echo '<h2> Boucles foreach  </h2>';
//-----------------------------------------------
// La boucle foreach permet de parcourir un array ou un objet de maniére automatique.
echo '<pre>'; print_r($tab); echo'</pre>';

foreach ($tab as $valeur ) {//parcourt l'array $tab par ses valeur . $valeur prend successivement à chaque tour de boucle les valeur contenue dans $tab
  echo $valeur . '<br>';
}

//-------
// Pour parcourir les indices Et les valeur :
foreach ($tab as $indice => $valeur) {// quandil y a 2 variable  la premier parcout la colonne des indices et la seconde colonne des valeurs
echo $indice . 'correspond' . $valeur .'<br>';
}

//Exercice : écrire un array avec les indice prenom , nom , email  et telephone , et y associer des valeur .
//puis vous afficher avec une boucle foreach les indice et les valkeur dans  des <p>, sauf por le prenom qui doit être dans un <h1>
$membre = array('prenom'  => 'johrdane',
                'nom'   => 'doe',
                'email' => 'jfdkf@hotmail.fr',
                'tel'   => '0105062547'
 );

foreach ($membre as $indice => $element) {
  if($indice == 'prenom'){
    echo "<h1>$indice : $element</h1>";
  }else {
    echo "<p>$indice : $element</p>";
  }
}
echo '<br>';echo '<br>';
//-----------------------------------------------
echo '<h2> tableaux multidimensionnels </h2>';
//-----------------------------------------------
// nous parlons de tableau multidimensionnels quand un tableau est contenue dans un autre tableauChaque tableau représente une dimension.

// creation d'un tableaux multidimensionnel :

$tab_multi = array(
         0=> array('prenom'=>'julien', 'nom'=>'Dupon' , 'tel'=>'0625148574'),
         1=> array('prenom'=>'Nicola', 'nom'=>'Duran' , 'tel'=>'0625148574'),
         2=> array('prenom'=>'pierre', 'nom'=>'Duchemo')
 );
echo '<pre>'; print_r($tab_multi); echo'</pre>';

// pour acceder a la valeur 'julien' :
echo $tab_multi[0]['prenom'] . '<hr>' ;// nous entron dans $tab_multi à l'indice 0 Pour aller ensuite à l'indice 'prenom'


// parcourir le tableau multidimensionnel avec une boucle for

for ($i=0; $i <count($tab_multi) ; $i++) {
  echo $tab_multi[$i]['prenom'] . '<br>';
}


//Exercice : Vous aller afficher les prenom de $tab_multi avec une boucle foreach.

foreach ($tab_multi as $key  => $value) {
   var_dump($value);
}

echo '<br>';echo '<hr>';
//-----------------------------------------------
echo '<h2> inclusion de fichier </h2>';
//-----------------------------------------------


echo 'pemiere inclusion :';
include('exemple.inc.php');// aprés include on precise le chemin du fichier a a inclure

echo '<br>Deuxème inclusion :' ;
include_once('exemple.inc.php');// once de include evite de d'afficher une 2"me fois le même fichier // verifie sis le fichier et deja inclus et si c le cas il ne fait pas l'inclusion

echo  '<br>troisiéme inclusion' ;
require('exemple.inc.php');

echo '<br>quatriéme inclusion' ;
require_once('exemple.inc.php');// avec once on verifi que le fichier n'est pas deja inclus

/*
           Differance entre unclude et require :
      1-Elle apparait si on ne parvien pas a inclure le fichier demander :

      2-include; génére une erreur de type warning , et continue l'execution du script

      3-require : génére une erreur de type fatale et stop l'execution du script


      -Le .inc dans le nom du fichier  est la à titre indicatif precisanr au devloppeur quil sagit d'un fichier d'inclusion,et non d'une page a part entière.
*/

echo '<br>';echo '<hr>';
//-----------------------------------------------
echo '<h2> Gestion Des Date </h2>';
//-----------------------------------------------

// La fonction predefini date() renvoie la date du jour selon le format spécifié :
echo date('d/m/Y H:i:s').'<br>';// retourne et affiche  date au format jour/Mois/Year ainsi que heure:minute:seconde

echo date('y-m-y h-i-s' );// affiche au format a-m-j .Note que l'on peut changer le separateur.


echo '<hr>';
//-----------------
/*
*Definition du time stamp Unix:
Le timestamp  est le nombre de seconde ecoulées entre une date et le 1er janveir 1970 à 00:00:00.
cetta date correspond  à la ceration d'unix premier systéme d'exploitation.

On Utilise timestamp dans de nombreux languages de programation dont le Php et javascript.
*/
 // La fonction  predefini time() retourne l'heure courante en time stamp :
 echo time();
 echo "<br>";

 // on va utiliser le timestamp pour passer une date d'un format vers un autre format :
 $dateJour= strtotime('29/05/2017'); // transforme la date en timesstamp
echo $dateJour .'<br>';

$dateFormat = strftime('%Y-%m-%d' , $dateJour) ; // transforme un timestamp en date au format indiqué

echo $dateFormat . '<br>' ;


echo '<br>';echo '<hr>';
//-------------
//Créé une date avec la class DateTime (approche objet) :
$date = new DateTime('30-05-2017');//on cree un objet $date de type DateTime en utilisant le mot cle new suivi du nom de la classe DateTime. on passe une date en argument de DateTime.

echo $date ->format('Y-m-d');// on peur fformater l'objet $date e appelant sa méthode format() et en lui indiquant les paramétres du format souhaité , ici Y-m-d.


//*****************************************************************************************************
echo '<br>';
//-----------------------------------------------
echo '<h2> Introduction aux objets </h2>';
//-----------------------------------------------
echo '<hr>';
// un objet est un autre type données. il permt de regrouper des informations : on peut y declarer des variable appelee atribut ou proprietes ainsi que des fonction appelees méthodes.

//Exemple 1:
//Nous creon une class appelee Etudiant qui nous permet de cree des objet de types Etudiant. Ils auront les attributs et les methode de cette classe

class Etudiant {
public $prenom = 'Johrdane ';
public $age    =  27;// $prenom, $age sont des attributs ..public permet de preciser qu'il seront accessible partout.
public function pays(){
  return' france';
   }
}
$objet = new Etudiant(); //new et un mot cle permettant d'instancier la class et d'en faire un objet.
echo '<pre>'; print_r($objet); echo '</pre>';// on voit le type de $objet, la class dont il est issu ,et les proprietes qu'il contient


echo $objet->prenom .'<br>';// poue acceder à la proprietes prenom qui est dans l'objet ,  je le lui met une fleche ->

echo $objet->age .'<br>'; // affiche l'age

echo $objet->pays().'<br>';// apppel d'une methode toujours avec les parenthèses

echo $objet->prenom . $objet->age . $objet->pays() . '<br>';// affiche les 2 prenom et age & pays avec un point pour les separé


//Exemple 2 : un panier d'achat de site e-commerce :
class Panier {
  public function ajout_article($article){
    //ici le code pour ajouter l'article au panier
    return"l'article $article a bien été  ajouter au panier";
  }
}
// creation d'un objet panier :
$Panier = new Panier();
echo $Panier->ajout_article('Pull');// appelle la methode ajout_article en lui passant l'argument "Pull" pour l'ajouter au panier . *Les methode s'appellent aprés une fléche -> e avec des parenthèses.




//

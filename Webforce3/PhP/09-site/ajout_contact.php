<?php

/* 1- Créer une base de données "contacts" avec une table "contact" :
	  id_contact PK AI INT(3)
	  nom VARCHAR(20)
	  prenom VARCHAR(20)
	  telephone VARCHAR(10)
	  annee_rencontre (YEAR)
	  email VARCHAR(255)
	  type_contact ENUM('ami', 'famille', 'professionnel', 'autre')

	2- Créer un formulaire HTML (avec doctype...) afin d'ajouter un contact dans la bdd. Le champ année
  est un menu déroulant de l'année en cours à 100 ans en arrière à rebours,
   et le type de contact est aussi un menu déroulant.

	3- Effectuer les vérifications nécessaires :
	   Les champs nom et prénom contiennent 2 caractères minimum, le téléphone 10 chiffres
	   L'année de rencontre doit être une année valide
	   Le type de contact doit être conforme à la liste des types de contacts
	   L'email doit être valide
	   En cas d'erreur de saisie, afficher des messages d'erreurs au-dessus du formulaire

	4- Ajouter les contacts à la BDD et afficher un message en cas de succès ou en cas d'échec.

*/
$message='';

$pdo = new
PDO('mysql:host=localhost;dbname=contacts','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

echo '<pre>' ; var_dump($_POST); echo '</pre>' ;

if(!empty($POST)){
if (strlen($_POST['prenom'])< 3 || strlen($_POST['prenom']) >20) $message .='Le prenom doit comprendre entre 3 et 20 caractaires <br>';
if (strlen($_POST['nom'])< 3 || strlen($_POST['nom']) >20) $message .='Le prenom doit comprendre entre 3 et 20 caractaires <br>';
if (strlen($_POST['telephone'])< 3 || strlen($_POST['telephone']) >10) $message .='Le telephone doit comprendre entre 10 et 10 caractaires <br>';


// controle de la date
function validateDate($date,$format ='Y-m-d'){
$d = dateTime::createFromFormat($format,$date);//cree un objet date au format indiqué dans $format ,ou bien retourne fals si la date fournie ne  respecte pas le format fournie

if($d && $d->format($format) == $date){//La date et correcte si $d  vaurt true (sinon  c'est que $date ne respecte pas le format fournie)Et que l'objet $d et formaté est identique à la date fourni (sinon que l'on a donné pas EXEMPLE 1975-02-30 au lieu de 1975-03-02)
return true;
 } else {
     return false;
 }
}
if(!validateDate($_POST['annee_rencontre'])) $message .=' date incorrecte!  <br>';

echo 'prenom :' . $_POST['prenom'] . '<br>';
echo 'email :' . $_POST['email'] . '<br>';
echo 'nom :' . $_POST['nom'] . '<br>';
echo 'annee_rencontre:' . $_POST['annee_rencontre'] . '<br>';
}
if ($_POST) {
if(empty($message)){
$resultat = $pdo->prepare("INSERT INTO contact(prenom,nom,telephone,annee_rencontre)VALUES
(:prenom,:nom,:telephone,:annee_rencontre)");// Les marqueur s'écrivent avec : colles au nom du marqueur ET sans les quotes

$resultat->bindParam(':prenom',$_POST['prenom'],PDO::PARAM_STR);
$resultat->bindParam(':nom',$_POST['nom'],PDO::PARAM_STR);
$resultat->bindParam(':telephone',$_POST['telephone'],PDO::PARAM_STR);
$resultat->bindParam(':annee_rencontre',$_POST['annee_rencontre'],PDO::PARAM_STR);
$resultat->execute();
echo 'le contacts a bien été ajouté';
   }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>formulaire</title>
  </head>
  <body>
    <h1>Formulaire</h1>
    <?php echo $message; ?>
    <form action="" method="post">
        <label for="nom">nom</label><br>
        <input type="text" name="nom" id="nom"><br><br>

        <label for="prenom">prénom</label><br>
        <input type="text" name="prenom" id="prenom"><br><br>

        <label for="telephone">telephone</label><br>
        <INPUT type="text" id="telephone" name="telephone"><br><br>

        <label for="annee_rencontre">annee de rencontre</label><br>
        <input type="date" max="2050-06-25" min="1950-08-13" name="annee_rencontre" id="annee_rencontre"><br><br>

        <label for="email">email</label><br>
        <input type="text" name="email" id="email"><br><br>

        <input type="submit" name="validation" value="envoyer">
    </form>
  </body>
</html>

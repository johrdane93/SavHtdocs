<?php
$message = '';

$pdo = new
PDO('mysql:host=localhost;dbname=entreprise','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
/*Exercice: cree un formulaire  qui permet d'enregistrer un nouvel employes dans la base de donnee "emtreprise" , en ecrivant le code suivant :
-1- creation du formulaire HTML
-2- connection a la BDD
-3- lorsque le formulaire est posté, insertion des donnees du formulaire dans la base avec une requete preparée
-4-Afficher un message "l'employé a bien ete ajoute"



id_contact PK AI INT(3)
  nom VARCHAR(20)
  prenom VARCHAR(20)
  telephone VARCHAR(10)
  annee_rencontre (YEAR)
  email VARCHAR(255)
  type_contact ENUM('ami', 'famille', 'professionnel', 'autre')





*/


echo '<pre>' ; var_dump($_POST); echo '</pre>' ;

if(!empty($POST)){
if (strlen($_POST['prenom'])< 3 || strlen($_POST['prenom']) >20) $message .='Le prenom doit comprendre entre 3 et 20 caractaires <br>';
if (strlen($_POST['nom'])< 3 || strlen($_POST['nom']) >20) $message .='Le prenom doit comprendre entre 3 et 20 caractaires <br>';
if (strlen($_POST['service'])< 3 || strlen($_POST['service']) >20) $message .='Le prenom doit comprendre entre 3 et 20 caractaires <br>';
if ($_POST['sexe'] != 'm' && $_POST['sexe'] != 'f')$message .= 'le sexe n\'est pas correct <br>' ;

if(!is_numeric($_POST['salaire']) || $_POST['salaire']<=0)$message .='le salaire doit être un nombre supérieur à 0<br>';// is numeric verifie si c'est un nombre decimal ou passant

// controle de la date
function validateDate($date,$format ='Y-m-d'){
$d = dateTime::createFromFormat($format,$date);//cree un objet dzte au format indiqué dans $format ,ou bien retourne fals si la date fournie ne  respecte pas le format fournie

if($d && $d->format($format) == $date){//La date et correcte si $d  vaurt true (sinon  c'est que $date ne respecte pas le format fournie)Et que l'objet $d et formaté est identique à la date fourni (sinon que l'on a donné pas EXEMPLE 1975-02-30 au lieu de 1975-03-02)
return true;
 } else {
     return false;
 }
}
if(!validateDate($_POST['date_embauche'])) $message .=' date incorrecte!  <br>';

echo 'prenom :' . $_POST['prenom'] . '<br>';
echo 'email :' . $_POST['email'] . '<br>';
echo 'nom :' . $_POST['nom'] . '<br>';
echo 'sexe:' . $_POST['sexe'] . '<br>';
echo 'the_date:' . $_POST['the_date'] . '<br>';
echo 'salaire:' . $_POST['salaire'] . '<br>';
echo 'Description :' .$_POST['Description']. '<br>';
}
if ($_POST) {
if(empty($message)){
$resultat = $pdo->prepare("INSERT INTO employes(prenom,nom,sexe,service,date_embauche,salaire)VALUES
(:prenom,:nom,:sexe,:service,:date_embauche,:salaire)");// Les marqueur s'écrivent avec : colles au nom du marqueur ET sans les quotes

$resultat->bindParam(':prenom',$_POST['prenom'],PDO::PARAM_STR);
$resultat->bindParam(':nom',$_POST['nom'],PDO::PARAM_STR);
$resultat->bindParam(':sexe',$_POST['sexe'],PDO::PARAM_STR);
$resultat->bindParam(':service',$_POST['service'],PDO::PARAM_STR);
$resultat->bindParam(':date_embauche',$_POST['date_embauche'],PDO::PARAM_STR);
$resultat->bindParam(':salaire',$_POST['salaire'],PDO::PARAM_STR);
$resultat->execute();
echo 'l\'employé a bien été ajouté';
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
        <label for="sexe">sexe</label><br>
        <INPUT type="radio" id="sexe" name="sexe" value="H" checked> Homme <INPUT type="radio" id="sexe" name="sexe" value="F"> Femme <br><br>
        <label for="date_embauche">Date d'embauche</label><br>
        <input type="date" max="2050-06-25" min="1950-08-13" name="date_embauche" id="date_embauche"><br><br>
        <label for="email">email</label><br>
        <input type="text" name="email" id="email"><br><br>
        <label for="service">service</label><br>
        <input type="text" name="service" id="service"><br><br>
        <label for="salaire">salaire</label><br>
        <input type="text" name="salaire" id="salaire"><br><br>
        <br>


        <input type="submit" name="validation" value="envoyer">
    </form>
  </body>
</html>

































<!--  -->

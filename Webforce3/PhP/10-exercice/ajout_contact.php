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
$pdo = new PDO('mysql:host=localhost;dbname=contacts','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

echo '<pre>' ; var_dump($_POST); echo '</pre>' ;

if(!empty($_POST)){
if (strlen($_POST['prenom'])< 3 || strlen($_POST['prenom']) >20) $message .='Le prenom doit comprendre entre 3 et 20 caractaires <br>';
if (strlen($_POST['nom'])< 3 || strlen($_POST['nom']) >20) $message .='Le prenom doit comprendre entre 3 et 20 caractaires <br>';
if (strlen($_POST['telephone'])< 3 || strlen($_POST['telephone']) >10) $message .='Le telephone doit comprendre entre 10 et 10 caractaires <br>';


// controle de la date
function validateDate($date,$format ='Y-m-d'){
$d = dateTime::createFromFormat($format,$date);

if($d && $d->format($format) == $date){
return true;
 } else {
     return false;
 }
}
if(!validateDate($_POST['anne_rencontre'])) $message .=' date incorrecte!  <br>';

echo 'prenom :' . $_POST['prenom'] . '<br>';
echo 'email :' . $_POST['email'] . '<br>';
echo 'nom :' . $_POST['nom'] . '<br>';
echo 'telephone :' . $_POST['telephone'] . '<br>';
echo 'anne_rencontre:' . $_POST['anne_rencontre'] . '<br>';


if(empty($message)){
$resultat = $pdo->prepare("INSERT INTO contact(prenom,nom,telephone,anne_rencontre)VALUES
(:prenom,:nom,:telephone,:anne_rencontre)");

$resultat->bindParam(':prenom',$_POST['prenom'],PDO::PARAM_STR);
$resultat->bindParam(':nom',$_POST['nom'],PDO::PARAM_STR);
$resultat->bindParam(':anne_rencontre',$_POST['anne_rencontre'],PDO::PARAM_STR);
$resultat->bindParam(':telephone',$_POST['telephone'],PDO::PARAM_STR);
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

        <label for="anne_rencontre">annee de rencontre</label><br>
        <input type="text" max="2050-06-25" min="1950-08-13" name="anne_rencontre" id="anne_rencontre"><br><br>

        <label for="email">email</label><br>
        <input type="text" name="email" id="email"><br><br>

        <div class="input-group">
        			<label for="categoty">Type de contact</label>
        	
        			<select name="categoty" id="categoty">
        				<?php
        				foreach($categoty as $key => $value){
        					echo '<option value="'. $value .'">'. $value .'</option>';
        				}
        				?>

        			</select>
        </div>



        <input type="submit" name="validation" value="envoyer">
    </form>
  </body>
</html>

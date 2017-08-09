<?php


$message='';

$category = array('ami', 'famille', 'professionnel', 'autre');


$pdo = new PDO('mysql:host=localhost;dbname=exercice_3','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

echo '<pre>' ; var_dump($_POST); echo '</pre>' ;

if(!empty($_POST)){
if (strlen($_POST['title'])< 3 || strlen($_POST['title']) >20) ;
if (strlen($_POST['actors'])< 3 || strlen($_POST['actors']) >20) ;
if (strlen($_POST['producter'])< 3 || strlen($_POST['producter']) >0) ;
if (strlen($_POST['year_of_prod'])< 3 || strlen($_POST['year_of_prod']) >4);

if (!in_array($_POST['category'], $category)){
		$contenu .= '<div>Le type de contact n\'est pas valide</div>';
	}
// if (strlen($_POST['storyline'])< 20 || strlen($_POST['storyline']) >20) $message .='Le telephone doit comprendre entre 10 et 10 caractaires <br>';


// controle de la date
function validateDate($date,$format ='Y-m-d'){
$d = dateTime::createFromFormat($format,$date);

if($d && $d->format($format) == $date){
return true;
 } else {
     return false;
 }
}
if(!validateDate($_POST['year_of_prod'])) $message .=' date incorrecte!  <br>';

echo 'title :' . $_POST['title'] . '<br>';
echo 'actors:' . $_POST['actors'] . '<br>';
echo 'producter :' . $_POST['producter'] . '<br>';
echo 'year_of_prod:' . $_POST['year_of_prod'] . '<br>';
echo 'category:' . $_POST['category'] . '<br>';


if(empty($message)){
$resultat = $pdo->prepare("INSERT INTO movies(title,actors,director,producter,language,category,storyline,Video)VALUES
(:title,:actors,:director,:producter,:language,:category,:storyline,:Video)");

$resultat->bindParam(':title:',$_POST['title'],PDO::PARAM_STR);
$resultat->bindParam(':actors',$_POST['actors'],PDO::PARAM_STR);
$resultat->bindParam(':director',$_POST['director'],PDO::PARAM_STR);
$resultat->bindParam(':producter',$_POST['producter'],PDO::PARAM_STR);
$resultat->bindParam(':year_of_prod',$_POST['year_of_prod'],PDO::PARAM_STR);
$resultat->bindParam(':language',$_POST['language'],PDO::PARAM_STR);
$resultat->bindParam(':category',$_POST['category'],PDO::PARAM_STR);
$resultat->bindParam(':Video',$_POST['Video'],PDO::PARAM_STR);
$resultat->execute();
echo 'le Film a bien été ajouté';
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
        <label for="title">titre du Film</label><br>
        <input type="text" name="title" id="title"><br><br>

        <label for="actors">acteur</label><br>
        <input type="text" name="actors" id="actors"><br><br>

        <label for="producter">Nom Du Producteur</label><br>
        <INPUT type="text" id="producter" name="producter"><br><br>

        <label for="year_of_prod">anne de production</label><br>
        <input type="date" max="2050-06-25" min="1950-08-13" name="year_of_prod" id="year_of_prod"><br><br>


        <div class="input-group">
          <label for="category">Type de Film</label>

          <select name="category" id="category">
      <?php
        foreach($category as $key => $value){
        echo '<option value="'. $value .'">'. $value .'</option>';
      }
      ?>



    </select>
  </div>

        <input type="submit" name="validation" value="envoyer">
    </form>
  </body>
</html>

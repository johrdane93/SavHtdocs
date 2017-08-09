<?php
echo '<br>';echo '<hr>';
//-----------------------------------------------------------------
//    cas pratique : un zspace de dialogue
//--------------------------------------------------------------

/* Objectif : creer un espace de dialogue de type avis ou livre d'or.

 Base de donnees : dialogue
 Table           : commentaires
 champs          : id_commentaires  INT(3) PK AI
                   pseudo           VARCHAR(20)
                   message           TEXTE
                   date_enregistrement DATETIME
*/
//connection a la BDD

$pdo = new
PDO('mysql:host=localhost;dbname=dialogue','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

// sil formulaire est posté:
if(!empty($_POST)){
  //3- le traitement contre les failles xss et les injection css: échapper les donnees.
  //exemple de fail CSS: <style>body{display:none}</style>
  //exemple de fail XSS: <script>whil(true){alert('tu t fait faire Sale!!!!);}</script>

  // pour s'en premunir
  $_POST['pseudo'] = htmlspecialchars($_POST['pseudo'],ENT_QUOTES);
  $_POST['message'] = htmlspecialchars($_POST['message'],ENT_QUOTES);
//caractaires speciaux(<,>,"",&,'') en entités html, ce qui permet de rendre inoffensiveLes balise HTML injecter dans le formulaire . on parle  d'echapement des donnees

// complement:
$_POST['message'] = strip_tags($_POST['message']);// supprime toutes les balises HTML contenues dans $_POST['message']

// htmlentities() permet aussi de convertire en entites HTMLLes caractaire speciaux  losqu'on fait un echo direct de donnees issu de l'internaute.

  //-1-Nous allon faire dans un premier temp une requete qui n'est pas proteger contre les injection et qui n'exepte pas les apostrophes.
  //$r = $pdo->query("INSERT INTO commentaire(pseudo, date_enregistrement,message)VALUES('$_POST[pseudo]',NOW(),'$_POST[message]')");

// Nous avons fait l'inbjection sql suivante dans le champ message : ok'); DELETE FROM commentaire;(
//Elle a pour conséquence l'effacement de la table commentaire. on va pour ce premunir de ce type d'injectioon un requete preparee :
$stmt =$pdo->prepare('INSERT INTO commentaire(pseudo, message,date_enregistrement) VALUES(:pseudo,:message, NOW())');
$stmt->bindParam(':pseudo',$_POST['pseudo'],PDO::PARAM_STR);
$stmt->bindParam(':message',$_POST['message'],PDO::PARAM_STR);
$stmt->execute();
// l'injection ne fonctione plus car on n'a mi des marqueur dans la requete plus des blidParam qui assainnissent les donner en neutralisant les morceaux de code passé dans le champ message
// on peut desormais aussi mettre des apostrophes dans les champ messages
}
?>
<form action="" method="post">
  <h2>Formulaire</h2>

  <label for="pseudo">pseudo</label>
  <input type="text" name="pseudo" id="pseudo">
    <br>
  <label for="message">message</label>
  <textarea name="message" id="message"></textarea>
    <br>
   <input type="submit" name="envoi" value="envoyer">




</form>
<?php
//affichage des message poster
$resultat=$pdo->query("SELECT pseudo,message,date_enregistrement FROM commentaire ORDER BY date_enregistrement DESC");

echo 'Nombre de commentaires :'. $resultat->rowCount();
while ($commentaire = $resultat->fetch(PDO::FETCH_ASSOC)) {
  echo'<div>';
   echo '<div> Pseudo :' . $commentaire['pseudo'] . ',le' . $commentaire['date_enregistrement'].'</div>';
    echo '<div>message:' . $commentaire['message'] .'</div>';
    echo '</div><hr>';
}

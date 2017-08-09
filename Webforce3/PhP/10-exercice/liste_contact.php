
<?php

$contenu='';
//connection a la bdd

$pdo = new PDO('mysql:host=localhost;dbname=contacts','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
// requette en bdd:
$query = $pdo->query("SELECT * FROM contact");
  $contenu .='<table border="1">';
  $contenu .='<tr> <th>prenom</th>
               <th>nom</th>
               <th>telephone</th>
              <th>autres infos</th>
              </tr>';

while ($contact = $query->fetch(PDO::FETCH_ASSOC)) {

  $contenu .='<tr>
               <td>'.$contact['prenom'].'</td>
               <td>'.$contact['nom'].'</td>
               <td>'.$contact['telephone'].'</td>
               <td><a href="?id_contact='.$contact['id_contacts'].'">autres info</a></td>
               </tr>';
}

$contenu .='</table>';
//detail :
if (isset($_GET['id_contact'])) {
  $query = $pdo->prepare("SELECT * FROM contact WHERE id_contacts = :id_contacts");
  $query -> bindParam(':id_contacts',$_GET['id_contact'],PDO::PARAM_STR);
  $query ->execute();

  $contact = $query->fetch(PDO::FETCH_ASSOC);

  $contenu .= '<p>Nom :'.$contact['nom'].'</p>';
  $contenu .= '<p>Prenom :'.$contact['prenom'].'</p>';
  $contenu .= '<p>Telephone :'.$contact['telephone'].'</p>';
  $contenu .= '<p>Email :'.$contact['email'].'</p>';
  $contenu .= '<p>Type de contact:'.$contact['type_contact'].'</p>';
  $contenu .= '<p>Annee  :'.$contact['anne_rencontre'].'</p>';
}

 echo  $contenu;
 ?>

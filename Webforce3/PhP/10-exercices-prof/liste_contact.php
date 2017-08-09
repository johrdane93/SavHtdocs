<?php
/*
	1- Afficher dans une table HTML la liste des contacts avec les champs nom, prénom, téléphone, et un champ supplémentaire "autres infos" avec un lien qui permet d'afficher le détail de chaque contact.

	2- Afficher sous la table HTML le détail d'un contact quand on clique sur le lien "autres infos".
*/
$contenu = '';


// 1- Cpnnexxion à la BDD :
$pdo = new PDO('mysql:host=localhost;dbname=contacts', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));


// 2- Requête en BDD :
$query = $pdo->query("SELECT * FROM contact");

$contenu .= '<table border="1">';
	$contenu .= '<tr>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Téléphone</th>
					<th>Autres infos</th>
				 </tr>';

	while($contact = $query->fetch(PDO::FETCH_ASSOC)){
		// echo '<pre>'; print_r($contact); echo '</pre>';
		$contenu .= '<tr>
						<td>'. $contact['nom'] .'</td>
						<td>'. $contact['prenom'] .'</td>
						<td>'. $contact['telephone'] .'</td>
						<td>
						<a href="?id_contact='. $contact['id_contact'] .'">autres infos</a>
						</td>	
					 </tr>';
	}

$contenu .= '</table>';


// Détail :
if(isset($_GET['id_contact'])){

	$query = $pdo->prepare("SELECT * FROM contact WHERE id_contact = :id_contact");
	$query->bindParam(':id_contact', $_GET['id_contact'], PDO::PARAM_STR);
	$query->execute();

	$contact = $query->fetch(PDO::FETCH_ASSOC);
	//echo '<pre>'; print_r($contact); echo '</pre>';

	$contenu .= '<p>Nom : '. $contact['nom'] .'</p>';
	$contenu .= '<p>Prénom : '. $contact['prenom'] .'</p>';
	$contenu .= '<p>Téléphone : '. $contact['telephone'] .'</p>';
	$contenu .= '<p>Email : '. $contact['email'] .'</p>';
	$contenu .= '<p>Type de contact : '. $contact['type_contact'] .'</p>';
	$contenu .= '<p>Année: '. $contact['annee_rencontre'] .'</p>';
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Liste contacts</title>
</head>
<body>

	<?php echo $contenu; ?>

</body>
</html>

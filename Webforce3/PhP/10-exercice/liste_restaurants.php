<?php
/*
	1- Afficher dans une table HTML la liste des restaurants avec les champs nom et téléphone, et un champ supplémentaire "autres infos" avec un lien qui permet d'afficher les autres restaurants.

	2- Afficher sous la table HTML le détail d'un contact quand on clique sur le lien "autres restaurants".

*/
$contenu = '';


// 1- Connexxion à la BDD :
$pdo = new PDO('mysql:host=localhost;dbname=restaurants', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));


// 2- Requête en BDD :
$query = $pdo->query("SELECT * FROM restaurant");

$contenu .= '<table border="1">';
	$contenu .= '<tr>
					<th>Nom</th>
					<th>Téléphone</th>
					<th>Autres infos</th>
				 </tr>';

	while($restos = $query->fetch(PDO::FETCH_ASSOC)){
		//echo '<pre>'; print_r($restos); echo '</pre>';
		$contenu .= '<tr>
						<td>'. $restos['nom'] .'</td>
						<td>'. $restos['telephone'] .'</td>
						<td> <a href="?id_restaurant='.$restos['id_restaurant'].'">autres infos </a>
						</td>
					 </tr>';
	}

$contenu .= '</table>';


// Détail :
if(isset($_GET['id_restaurant'])){

  $_GET['id_restaurant'] = htmlspecialchars($_GET['id_restaurant']);

	$query = $pdo->prepare("SELECT * FROM restaurant WHERE id_restaurant = :id_restaurant");
	$query->bindParam(':id_restaurant', $_GET['id_restaurant'], PDO::PARAM_STR);
	$query->execute();

	$restos = $query->fetch(PDO::FETCH_ASSOC);
	//echo '<pre>'; print_r($restos); echo '</pre>';

	$contenu .= '<p>Nom : '. $restos['nom'] .'</p>';
	$contenu .= '<p>Adresse : '. $restos['adresse'] .'</p>';
	$contenu .= '<p>Téléphone : '. $restos['telephone'] .'</p>';
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>liste_Restaurants</title>
</head>

<body>

	<?php echo $contenu; ?>

</body>
</html>

<!DOCTYPE html>
<html dir="ltr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Créer une salle</title>
	<link rel="stylesheet" href=".css/create_room.css" type="text/css" media="screen" />
</head>
<body>
	<div id="container">
		<h1>Création d'une salle de tchat</h1>
		<form method="post" id="customForm" action="process.php">
			<div>
				<label for="name">Nom*</label>
				<input id="name" name="name" type="text" />
				<span id="nameInfo">*Champ requis</span>
			</div>
			<div>
				<label for="pass1">Mot de passe</label>
				<input id="pass1" name="pass1" type="password" />
				<span id="pass1Info">Au moins 5 caractères, sans caractères spéciaux</span>
			</div>
			<div>
				<label for="pass2">Confirmation du mot de passe</label>
				<input id="pass2" name="pass2" type="password" />
				<span id="pass2Info"></span>
			</div>
			<div>
				<img id="captcha" src="tools/securimage/securimage_show.php" alt="CAPTCHA Image" />
			</div>
			<div>
				<input type="text" name="captcha_code" size="10" maxlength="6" />
				<a href="#" onclick="document.getElementById('captcha').src = 'tools/securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>
			</div>
			<div>
				<input id="send" name="send" type="submit" value="OK" />
			</div>
			<?php
				if(isset($_GET['err']) && $_GET['err'] == 1){
					echo "<p style='font-size:16px;color:red;'>Le captcha ne correspond pas. Veuillez réessayer.</p>";
				}
			?>
		</form>
	</div>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/verif_form.js"></script>
</body>
</html>
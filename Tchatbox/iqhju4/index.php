<?php
session_start();
include_once "../tools/securimage/securimage.php";
$securimage = new Securimage();

$form1 = '
<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Vérification du mot de passe</title>
	<link rel="stylesheet" href="../css/create_room.css" type="text/css" media="screen" />
</head>
<body>
	<div id="container">
	<h1>Vérification du mot de passe</h1>
	<form id="customForm" method="POST" action="index.php">
		<label for="pass1">Mot de passe</label>
		<input id="pwd" name="pwd" type="password" /><br><br>
';
$form2 = '
		<img id="captcha" src="../tools/securimage/securimage_show.php" alt="CAPTCHA Image" /><br>
		<input type="text" name="captcha_code" size="10" maxlength="6" />
		<a href="#" onclick="document.getElementById("captcha").src = "../tools/securimage/securimage_show.php?" + Math.random(); return false">[ Different Image ]</a><br><br>
';
$form3 = '
		<input id="send" type="submit" value="OK"></input><br><br>
	</form>
	</div>
</body>
</html>
';

include('../tools/functions.php');
$json_file = file_get_contents('conf.json');
$jfo = json_decode($json_file);
$pwd = encrypt_decrypt('decrypt',$jfo[0]->pwd);

if($pwd == ""){
	include('tchatbox.php');
}
elseif(isset($_POST['pwd'])){
	if($_POST['pwd'] == $pwd && !isset($_POST['captcha_code'])){
		include('tchatbox.php');
	}
	elseif($_POST['pwd'] != $pwd && !isset($_POST['captcha_code'])){
		echo $form1;
		echo $form2;
		echo $form3;
		echo "<p style='font-size:16px;color:red;'>Le mot de passe ne correspond pas.</p><br>";
	}
	elseif($_POST['pwd'] == $pwd && isset($_POST['captcha_code']) && $securimage->check($_POST['captcha_code']) == true){
		include('tchatbox.php');
	}
	elseif($_POST['pwd'] == $pwd && isset($_POST['captcha_code']) && $securimage->check($_POST['captcha_code']) == false){
		echo $form1;
		echo $form2;
		echo $form3;
		echo "<p style='font-size:16px;color:red;'>Le captcha ne correspond pas. Veuillez réessayer.</p><br>";
	}
	elseif($_POST['pwd'] != $pwd && isset($_POST['captcha_code']) && $securimage->check($_POST['captcha_code']) == true){
		echo $form1;
		echo $form2;
		echo $form3;
		echo "<p style='font-size:16px;color:red;'>Le mot de passe ne correspond pas.</p><br>";
	}
	elseif($_POST['pwd'] != $pwd && isset($_POST['captcha_code']) && $securimage->check($_POST['captcha_code']) == false){
		echo $form1;
		echo $form2;
		echo $form3;
		echo "<p style='font-size:16px;color:red;'>Le mot de passe et le captcha ne correspondent pas. Veuillez réessayer.</p><br>";
	}
	else{
		echo $form1;
		echo $form2;
		echo $form3;
	}
}
else{
	echo $form1;
	echo $form3;
}
?>
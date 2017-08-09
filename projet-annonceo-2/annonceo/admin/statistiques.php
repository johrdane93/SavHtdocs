<?php

require_once('../inc/init.inc.php');

if(!internauteEstConnecteEtEstAdmin())
{
	header("../location:connexion.php");
	exit(); // interrompt le script
}

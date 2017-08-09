<?php
copy("chat.txt","chat.csv");
$lines = file('chat.txt');
$temp = array();
array_push($temp,"Auteur;Message;Heure;\n");
foreach ($lines as $line_num => $line) {
	$line = html_entity_decode($line);
	$line = utf8_decode($line);
	$spaceString = str_replace( '<', ' <',$line );
	$doubleSpace = strip_tags( $spaceString );
	$singleSpace = str_replace( '  ', ';', $doubleSpace );
	array_push($temp,$singleSpace);
}
file_put_contents('chat.csv', $temp);

header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"" . basename("chat.csv") . "\""); 
readfile("chat.csv");

if(file_exists("chat.csv")){
	unlink("chat.csv");
}
?>
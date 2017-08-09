<?php
copy("chat.txt","chat.html");
$lines = file('chat.txt');
$temp = array();
array_push($temp,"<table style='border-collapse: collapse;'>");
array_push($temp,"<tr><th>Auteur</th><th>Message</th><th>Heure</th></tr>");
foreach ($lines as $line_num => $line) {
	$arr = explode('</span>', $line);
	$name = str_replace('<span>','',$arr[0]);
	$content = $arr[1];
	$time = substr($line,-12);
	$time = str_replace('</span>','',$time);
	array_push($temp,"<tr style='border: none;'><td style='text-align:center;'>".$name."</td><td style='border-left:solid 1px #f00;border-right: solid 1px #f00;border-color:grey;'>".$content."</td><td style='text-align:center;'>".$time."</td></tr>");
}
array_push($temp,"</table>");
file_put_contents('chat.html', implode(PHP_EOL, $temp));

header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"" . basename("chat.html") . "\""); 
readfile("chat.html");

if(file_exists("chat.html")){
	unlink("chat.html");
}
?>
<?php
session_start();

include('classes/class.room.php');
include_once 'tools/securimage/securimage.php';
$securimage = new Securimage();

if ($securimage->check($_POST['captcha_code']) == false) {
  echo "Le captcha est incorrecte !";
  header('Location: index.php?err=1');
  exit;
}
if(isset($_POST['name'])) { 
	$roomName = $_POST['name']; 
}
if(isset($_POST['pass1'])) {	
	$roomPwd = $_POST['pass1'];
}
$MyRoom = new room($roomName,$roomPwd);
header('Location: '.$MyRoom->getUrl()); 
?>
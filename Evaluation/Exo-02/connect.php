<?php

$db = new PDO('mysql:host=localhost;dbname=exo1_userslist', 'root', '',
  array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
);

<?php

 //Requete SQL pour l'exercice 1
 "SELECT * FROM articles
 INNER JOIN users ON users.id = articles.id_user
 WHERE articles.id = 10 AND articles.id_user = users.id";

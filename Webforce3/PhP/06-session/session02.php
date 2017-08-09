<?php
//ouverture de la session en cours:
session_start();// losque j'effectur un session_start la session n'est pas recree car elle existe deja ( elle a ete crees dans le fichier session1.php)

echo 'la session et accessible dans tout les scripts du site comme ici:';
echo' <pre>'; print_r($_SESSION); echo '</pre>';
// conclusion : ce fichier n'a paq de lien avec session1.0php il n'y a pas d'inclusion , il pourrait être dans n'importe quel dossier du site , s'appeler
//n'importe comment et pourtant les info du fichier de session restent accessible grace a session_start.

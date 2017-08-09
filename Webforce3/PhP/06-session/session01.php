<?php
//--------------------------
// session
//-----------------
/*
PRINCIPE ; Un fichier temporaire appeleé session et cree sur le serveur avec un ID unique.cette session et lier a un internaut
e  car dans le même temp , un cookie et deposer dans le naviguateur de l'internaute
avec L'id  Ce cooki inactif lorsqu'on quitte le navigateur : la session s'interrompe
alor

Le fichier de session peut contenire toute sorte d'information , i compris sensible car il  n'est pas accesible par l'internaute
, on n'y stocke  donc par exemple des logins de connection , des paniers d'achat , ect...

Si l'internaute modifie le cookie relatif à une session, le lien avec celle-ci est rompue et
et l'internaute et deconnecte
On recup les donner de la session dans la superglobale $_SESSION.

*/
// Creation ou ouverture d'une session :
session_start(); //permt de cree un fichier d session sur le serveur ou de l'ouvrire si il existe deja.

// remplissage de la session:
$_SESSION['pseudo'] =' tintin';
$_SESSION['mdp'] =' milou';// $_SESSION étant un array , il ce remplie comme tout les tableaux en mettant un indice entre crochet et en lui effectant une valeur

echo'1- la session apre remplissage:';
echo' <pre>'; print_r($_SESSION); echo '</pre>';// affiche les information contenue dans la session .La session ce trouve sur xampp/tmp/


// Vider une partie de la session :
unset($_SESSION['mdp']);// nous pouvons vider une partie de la session avec unset()

echo'2. La session apres suppression du mdp : '  ;
echo' <pre>'; print_r($_SESSION); echo '</pre>';


// supprimer entièrement la session :
//session_destroy();//supprime toute la session
echo'3. session apres session_destroy():';
echo' <pre>'; print_r($_SESSION); echo '</pre>';
//on voit encore la session à cet endroit car le session_destroy a la particularite d'être executer qu'à la fin du script, c'est a die apres ce print_r

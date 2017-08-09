/*--------------------------------------------------------------------------
-                     Les Fonctions
-----------------------------------------------------------------*/

// Déclarer une Fonction
// cette Fonction ne retourne aucune valeur
function DitBonjour(){
    //--Lors de l'appel de la fonction, les instructions ci-dessous seront executers.
     alert("bonjour!");
}

DitBonjour();

// --declaré une Fonction qui prend une variable en paramètre

function Bonjour(prenom){
//--Ici,prenom et une variable a porter localz.cette variable,ne sera pas axessible que dans cette fonction!
  document.write("<p>Hello<strong>"+prenom+"</strong> !<p>");
}

//--Appeler / Utiliser une fonction avec un parametre
Bonjour("Hugo")
/*----------------------------------------------------------------------
-Exercice : Crée une fonction permettant d'effectuer l'Addition de deux nombres passer en parametre.
--------------------------------------------------------------------------------*/
function addition(nb1,nb2){
   //-- Le mot Clé"return" permet de renvoyer une valeur en sortie.
    var resultat = nb1 + nb2;
     return resultat;
}
 var resultat = addition(10, 5);
 document.write("<p>"+ resultat +"</p>");

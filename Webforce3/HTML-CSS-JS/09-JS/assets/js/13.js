/*----------------------------------------------------------------------
                            LES evenement                              |
-------------------------------------------------------------------------
Les evenement vont me permétre de déclancher une fonction c'est a dire:
une séri d'instruction, suite à une action de mon utilisateur

Objectif : etre en mesure de capturer ces evenement
, afin d'executer une fonction
-------------------------------------------------------------------------*/

//-- Les Evenement :MOUSSE (Souris)
     // click : au clic sur un ELEMENT
     // mouseenter :la souris passe au dessu de la zone qu'occupe un element.
     // mouseleave : la souris sort de cette zone

//-- Les evenement : KEYBOARD (Clavier)
  // keydown : une touche du clavier est enfoncée
  // keyup   : une touche a été relachée

//-- Les evenement : WINDOWS (fenetre)
      //scroll : défilement de la fenetre.
      // resize : redimenssionnement de la fenetre

// --les evenement : FORM (formulaire)
     //  change : pour les element <input>, <Select> et <textarea>
     //  submit : à l'envoi d'un formulaire

// -- les evenement : DOCUMENT
      // DOMContentLoaded : executer lorsque le contenu HTML est completement charger sans attendre le CSS et les images.


/*-----------------------------------------------------------------------------------------------------
                         LES ECOUTEUR D'EVENEMENT
----------------------------------------------------------------------------------------------*/
 /*-- Pour attacher un événement a un élément , ou autrement dit, pour declarer un ECOUTEUR d'evenement
  qui ce chargera de lancer une action, c'est a dire une fonction pour un evenement donné,
   je vais utiliser la syntaxe suivante:                                               */

var p = document.getElementById("MonParagraphe");
console.log("p");

//-_ je souhaite que mon Paragraphe soit rouge au clic de la souris
      //1 --je defini une fonction chargee d'executer cette action.
         function changeColorToRed(){
           p.style.color ="red";
         }

//2-- je declare un ECOUTEUR qui ce chargera d'appeler la fonction au déclenchement de l'événement.
     p.addEventListener("click",changeColorToRed);




/*--------------------------------------------------------------------------------------------
                                     EXECICE PRATIQUE
  A l'aide de javascript, créez un champ "imput" type text avec un ID unique.
  afficher enssuite dans une alert, la saisie de l'utilisateur.
-----------------------------------------------------------------------------------------------------*/


// --- creation du champ input
var input = document.createElement('input');
// ---atribution d'un atribution
  input.setAttribute('type','text');

// --- atribution d'un ID
  input.id = "MonInput";

// -- ajout de l'element dans la page.
document.body.appendChild(input);


// ---------------------

// -- création d'un ECOUTEUR
input.addEventListener('change',afficheLaSaisieDeMonInput);

function afficheLaSaisieDeMonInput(){
     alert(input.value);
}
/**/ 

//BASE DE DONNEES ID MDP

var email,mdp;

email = "dodo@dodo.fr";
mdp   = "wf3";

// 1-- demander son email a l'utilisateur avec un prompt

var emailLogin = prompt("Bonjour quel est vrotre email ? ","saisissez votre email");
//-2~~ je verifie si l'email saisie (EmailLogin) coresspond a celui en base de donnée (email)
 if (emailLogin === email) {
  //2,a.~~ Si tout et ok je continu la verification avec le mot de passe.
      var mdpLogin = prompt("votre mot de passe","taper votre mot de passe");
        if(mdpLogin === mdp){
          alert("bienvenue utilisateur !");
        }
        else {
          //2a2. Si les Mdp ne correspondent pas , je lance une alert.
          alert("ATTENTION, nous n'avons pas reconnu votre mot de passe ");
        }
 }else {
  //2b. Sinon,Les emails ne correspondent pas , je lance une alert.
  alert("ATTENTION, nous n'avons pas reconnu votre emails ")
 }

 /*----------------------------------------------------------------------------
 -              Les operateurs de logiques
 ----------------------------------------------------------------------------*/
// L'operateurs ET : && ou AND
// -- Si la combinaison emailLogin et email coresspond ET la combinaison mdp login et mdp coresspond
// Dans cette condition, au moins l'une des deux condition doit correspondre pour être valider
if( ("emailLogin === email") && ("mdpLogin === mdp") ) {...}
// l'opérateur OU : || ou OR
// -- Si la combinaison emailLogin et email coresspond OU la combinaison mdpLogin et mdp correspond.
//-- ici dans cette condition , au moinsl'une  des deux doit correspondre pour être valider
if( ("emailLogin === email") || ("mdpLogin === mdp") ) {...}
// --L'operateurs "!" : Qui signifie le contraire de , ou encore NOT
var siMonUtilisateurEstApprouve = true;
  if(!siMonUtilisateurEstApprouve){
    // Si l'utilisateur n'est pas approuvé.
  }
  // Reviens egalement a écrire :
  if(siMonUtilisateurEstApprouve == false) {   }


/*------------------------------------------------------------------------
-                         Les Conditions
--------------------------------------------------------------------*/

 // var MajoriteLegalFR = 18;
 // if(MajoriteLegalFR >= 19){
 //       alert(" Bienvenu! ");}
 //       else {
 //         alert('Google...');
 //       }




/*----------------------------------------------------------------------
-                                  Exercice                             -
-    Cree une fonction permettant de vérifier l'age du visiteur .       -
-    S'il a la majorite legale , alor je lui souhaite la bienvenue,     -
-    Sinon, je fait une redirection sur Google après lui avoir          -
-     signalé le soucis                                                 -
------------------------------------------------------------------------*/
// 1--Déclarer la Majorite Legal.
      var MajoriteLegalFR = 18;

    //2--Cree une fonction pour demander son l'age
        function verifierAge() {
          // -- Demande de l'age de mon visiteur et le retourner.
          return parseInt(prompt("Bonjour, quel age avez-vous?","<saisissez votre age>"));
        }
        // 3-- une condition pour verifier si l'age de l'utilisateur est superieur ou egale a la MajoriteLegalFR
        if(verifierAge() >= MajoriteLegalFR) {
          // -- j'affiche un message de bienvenue
          alert("bienvenue sur mon site internet pour les majeur....");
        }
        else {
          //--j'affiche une alert
          alert("ATTENTION !!! Vous devez être majeur pour accéder a ce site !")
        }
        // je redirige vers Google
         document.location.href = "https://www.google.fr";
/*-----------------------------------------------------------------------------------------
-Les operateurs de comparaison

//--l'opérateur de comparision "==" signifie  : Egal à ...il permet de vérifier que 2 variables sont identiques.
//--l'opérateur de comparision "===" signifie : strictement Egal ...il va comparer la valeur et aussi le type de données.
//--l'opérateur de comparision "!=" signifie  : Différent de.
//--l'opérateur de comparision "!==" signifie : Strictement Différent de.
-----------------------------------------------------------------------------------------------*/

/* ------------------------------------------------------------------------------------------------------
-                                 EXERCICE                                                                -
-    J'arrive sur un Espace Sécurisé au moyen d'un email et d'un mot de passe.                            -
-    Je doit saisir mon email et mon mot de passe afin d'être authentifié sur le site.                    -
-    En cas d'échec une alert m'informe du problème.                                                      -
-    Si tous se passe bien, un message de bienvenue m'acceuil.                                            -
-------------------------------------------------------------------------------------------------- */











































// function login()
// {
//     var email,mdp = prompt( "Veuillez entrer le mot de passe pour accéder à cette page", "" );
//     // si un mot de passe a été entré
//     if ( email,mdp != null )
//     {
//     	// on le compare à celui attendu
//     	if ( email,mdp == "bravo" )
//     	{
//     	    // mot de passe valide, on ouvre la page secrète
//     	    document.location.href = "https://www.google.fr/";
//         }
//         else
//         {
//             alert( "Mot de passe incorrecte!", "Erreur" );
//         }
//     }
// }

// function Login () {
// }
// //  function Login(){
// var done=0;
// var username=document.login.username."didine";
// var password=document.login.password."didine93";
//
//        // Récupère le formulaire
// var monForm=document.getElementById('login');
// if (username=="didine" && password=="didine93") {
//   //window.location="user1.html";
//   //Définit l'attribut action au formulaire.
//   // -> En gros dire vers où j'envoie / je vais, après avoir validé le formulaire
//   monForm.setAttribute('action', '08-LesConditions.html');
//   done=1;
// }
//
// if (username=="didine" && password=="didine93") {
//   // Vous pouvez réservez une page pour vous même(options, etc.)
//   //window.location="vous.html";
//   monForm.setAttribute('action', '08-LesConditions.html');
//   done=1;
// }
// /*
// * Si tout est ok, il y a plus qu'a valider le formulaire
// */
// if (done==1) {
//  monForm.submit();
// }

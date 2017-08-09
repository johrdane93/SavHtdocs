/*--------------------------------------------------------------------------------------
a partire du tableau fourni  vous devez mettre en place un system d'authentification.
Apres avoir demandeé a votre utlilisateur son email et mot de passe , et apres avoir vérifié ses information
, vous lui souhaitrez la bienvennue avec son nom et prenom en html avec (document.write);
----------------------------------------------------------------------------------------*/
var email, mdp;

email = "@.com";
mdp = "dodo";

// // 1 -- Demander son Email
// var emailLogin = prompt("Bonjour, Quel est votre email ?", "<Saisissez votre Email>");
//
// // 2 -- Je vérifie si l'email saisie
// if(emailLogin === email) {
//
//     var mdpLogin = prompt("votre mot de passe ?", "<Saisissez votre Mot de Passe>");
//     if(mdpLogin === mdp) {
//         document.write("Bienvenu Utilisateur !");
//     }
//     else {
//
//         document.write("ATTENTION, nous n'avons pas reconnu votre mot de passe.");
//     }
//     }
//       else {
//
//     document.write("ATTENTION, nous n'avons pas reconnu votre adresse email.");
// }

/*----------------------------------------------------------------------
                          teste01
-------------------------------------------------------------*/

/*UserID and Password*/

var unArray = ["Philip", "George", "Sarah", "Michael"];
var pwArray = ["Password1", "Password2", "Password3", "Password4"];

function pasuser(form) {
if (form.id.value=="dodo") {
if (form.pass.value=="dada") {
location="exercice3.html"
} else {
alert("Invalid Password")
}
} else {  alert("Invalid UserID")
}
var count = 2;
function validate() {
var un = document.myform.username.value;
var pw = document.myform.pword.value;
var valid = false;
}

for (var i=0; i <unArray.length; i++) {
if ((un == unArray[i]) && (pw == pwArray[i])) {
valid = true;
break;
}
if (valid) {
alert ("Login was successful");
window.location = "http://www.google.com";
return false;
}
var t = " tries";
if (count == 1) {t = " try"}

if (count >= 1) {
alert ("Invalid username and/or password.  You have " + count + t + " left.");
document.myform.username.value = ["Philip", "George", "Sarah", "Michael"];
document.myform.pword.value = ["Password1", "Password2", "Password3", "Password4"];
setTimeout("document.myform.username.focus()", 25);
setTimeout("document.myform.username.select()", 25);
count --;
}

else {
alert ("Still incorrect! You have no more tries left!");
document.myform.username.value = "No more tries allowed!";
document.myform.pword.value = "";
document.myform.username.disabled = true;
document.myform.pword.disabled = true;
return false;
}


}
/*-----------------------------------------------------------------------------
                                teste02
------------------------------------------------------------------*/












}

// 1-saisir son prnom dans un prompt 2-retourner à l'utilisateur : bonjour []




// // 1-saisir son prnom dans un prompt
// var reponse = prompt("Comment t'appelles-tu ?", "  ");
// if( reponse == null ){
//     alert("Vous avez cliqué sur Annuler");
// }
// else {
//     alert("Bonjour " + reponse + ", ça roule ?");
// }
//
// // 2-retourner à l'utilisateur:bonjour [Prenon], quel age as-tu ?
//
// var reponse = prompt(" alors "+ reponse + " quel et bta date de naissance ?");
// if( reponse == null ){
//     alert("Vous avez cliqué sur Annuler");
//
// }
//
// //--03
// var reponse = prompt(" Oulaaa!!!tu et Bien jeunes ");
// if( reponse == null ){
//     alert("Vous avez cliqué sur Annuler");
// }

// --cerrction

// -initialisation des variable
var DateDuJour = new Date();

// 2-- Creation de la fonction
function Hello() {

  //  je demande a l'utilisateur son prenom
  prenom = prompt("Hello ! what is your name ?", "...");

  // je lui demande son age
  age = parseInt(prompt("Hello"+ prenom +"how old are you ?","<saisir votre age>"));

  // j'affiche une alert avec sont annee de naissance
  alert("yo"+(DateDuJour.getFullYear() -age)+"!");

  // affichage dans ma page html
  document.write(" Hello " + prenom + " tu a " + age + "Ans! GoodGame ");

}
// execution de mafio
Hello();

/* ---------------------------
    LA CONCATENATION
------------------------------*/

var DebutDePhrase       =  "Aujourd'hui ";
var DateDuJour          =  new Date();
var SuiteDePhrase       =  ", sont présents : ";
var NombreDeStagiaires  =  11;
var FinDePhrase         =  " stagiaires.<br>";

// -- Nous souhaitons maintenant, grâce à la concentration, afficher tout ce petit monde, en un seul morceau !

document.write(DebutDePhrase + DateDuJour.getDate() + "/" + (DateDuJour.getMonth() + 1) + "/" + DateDuJour.getFullYear() + SuiteDePhrase + NombreDeStagiaires + FinDePhrase);

/* ---------------------------
    EXERCICE : 
    Créez une concaténation à partir des éléments suivants:
------------------------------*/

var phrase1 = "Je m'appelle ";
var phrase2 = "Rudy et j'ai ";
var age     = 20;
var phrase3 = " ans ! "

document.write(phrase1 + phrase2 + age + phrase3);
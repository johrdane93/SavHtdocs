// -- Déclarer un Tableau Numérique
var monTableau = [];
var myArray    = new Array;

// -- Affecter des Valeurs à un Tableau Numérique 
myArray[0] = "John";
myArray[1] = "Rudy";
myArray[2] = "Teva";
myArray[3] = "Carole";

// -- Afficher le contenu de mon Tableau Numérique dans la console.

console.log(myArray[2]); // -- Teva
console.log(myArray[0]); // -- John
console.log(myArray); // -- Affiche toutes les données

// -- Déclarer et Affecter des Valeurs à un Tableau Numérique

var NosPrenoms = ["Nabila", "Karim", "Johrdane", "Hanane"];
console.log(NosPrenoms);
console.log(typeof NosPrenoms);

// -- Déclarer et Affecter des Valeurs à un Objet (Pas de Tableau Associatif en JS)

var Coordonee = {
    "prenom"    :   "Rudy",
    "nom"       :   "HERICOURT",
    "age"       :   20
    
}

console.log(Coordonee);
console.log(typeof Coordonee);

// -- Comment créer et affecter des valeurs à un Tableau de 2 dimensions.

// -- Ici, il s'agit de Tableaux Numériques 
var listeDeNoms     = ["LIEGEARD", "NOUEL", "ISOLA"];
var listeDePrenoms  = ["Hugo", "Rodrigue", "Patrick"];

// -- Je vais créer un tableau à 2 dimensions à partir de mes 2 tableaux précédents
var Annuaire = [listeDePrenoms, listeDeNoms];
console.log(Annuaire);

// -- Afficher un Nom et un Prénom sur ma Page HTML !

document.write(Annuaire[0][1]);
document.write(" ");
document.write(Annuaire[1][1]);

/* ---------------------------
    EXERCICE :
    
    Créez un Tableau à 2 dimensions appelé AnnuaireDesStagiaires qui contiendra toutes les coordonnées pour chaque stagiaire.
    
    Ex. Nom, Prenom, Tel
------------------------------*/

var AnnuaireDesJoueursDuReal = [
    {"prenom" : "Cristiano", "nom" : "Ronaldo", "numero" : "7"},
    {"prenom" : "Gareth", "nom" : "Bale", "numero" : "11"},
    {"prenom" : "Karim", "nom" : "Benzema", "numero" : "9"}
];

console.log(AnnuaireDesJoueursDuReal);

/* ---------------------------
    AJOUTER UN ELEMENT
------------------------------*/

var Couleurs = ['Bleu', 'Jaune', 'Vert', 'Orange'];

// -- Si je souhaite ajouter un élément dans mon tableau.
// -- Je fait appel à la fonction push() qui me renvoi le nombre d'éléments de mon tableau.

// -- NB : La Fonction unshift() permet d'ajouter un ou plusieur éléments en début de tableau.

Couleurs.push("Rouge");
console.log(Couleurs);
console.log(nombreElementsDeMonTableau);

/* ----------------------------------------
   RECUPERER ET SORTIR LE DERNIERE ELEMENT
-----------------------------------------*/

// -- La fonction pop() me permet de supprimer le dernier de mon tableau et d'en récupérer la valeur.

// -- Je peux accesoirement récupérer cette valeur dans une variable.

var monDernierElement = Couleurs.pop();

// -- La même chose est possible avec le premier élément en utilisant la fonction shift();

// -- NB : La fonction splice() vous permet de faire sortir un ou plusieurs éléments de votre tableau.



















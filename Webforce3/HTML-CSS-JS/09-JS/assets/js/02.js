// -- Déclarer un Tableau Numérique
var monTableau  = [];
var myArray     = new Array;

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

var Coordonnee = {
    "prenom"    :   "Hugo",
    "nom"       :   "LIEGEARD",
    "age"       :   27
}

console.log(Coordonnee);
console.log(typeof Coordonnee);

// -- Comment créer et affecter des valeurs à un Tableau de 2 dimensions.

// -- Ici, il s'agit de Tableaux Numériques
var listeDeNoms     = ["LIEGEARD", "NOUEL", "ISOLA"];
var listeDePrenoms  = ["Hugo", "Rodrigue", "Patrick"];

// -- Je vais créer un tableau a 2 dimensions à partir des mes 2 tableaux précédents
var Annuaire = [listeDePrenoms, listeDeNoms];
console.log(Annuaire);

// Afficher un Nom et un Prénom sur ma Page HTML !

document.write(Annuaire[0][1]);
document.write(" ");
document.write(Annuaire[1][1]);

/* ---------------------
  EXERCICE :
  
  Créez un Tableau à 2 dimensions appelé AnnuaireDesStagiaires qui contiendra toutes les coordoonnées pour chaque stagiaire.
  
  Ex. Nom, Prénom, Tel  
---------------------- */

var AnnuaireDesStagiaires = [
    {"prenom" : "Hugo", "nom" : "LIEGEARD", "tel" : "0783 97 15 15"},
    {"prenom" : "Rodrigue", "nom" : "NOUEL", "tel" : "0696 07 04 34"},
    {"prenom" : "Patrick", "nom" : "ISOLA", "tel" : "+3378765434"},
];

console.log(AnnuaireDesStagiaires);

// -- Exemple pour la 3D

var Contacts = [

    {
        "prenom"        :   "Hugo",
        "nom"           :   "LIEGEARD",
        "coordonnes"    :   {
                                "email"   :     "wf3@hl-media.fr",
                                "tel"     :     {
                                                    "fixe"  :   "0596 108 328",
                                                    "fax"   :   "0596 108 632",
                                                    "port"  :   "0696 77 89 19"
                                                },
                                "adresse" :     {
                                                    "ville" :   "Ducos",
                                                    "cp"    :   97224,
                                                    "region":   "Martinique",
                                                    "pays"  :   "France"
                                                }
                            }
    },

    {
        "prenom"        :   "Rodrigue",
        "nom"           :   "NOUEL",
        "coordonnes"    :   {
                                "email"   :     "wellcommunication.net@gmail.com",
                                "tel"     :     {
                                                    "fixe"  :   "0596 XXX XXX",
                                                    "fax"   :   "0596 XXX XXX",
                                                    "port"  :   "0696 XX XX XX"
                                                },
                                "adresse" :     {
                                                    "ville" :   "Fort-de-France",
                                                    "cp"    :   97200,
                                                    "region":   "Martinique",
                                                    "pays"  :   "France"
                                                }
                            }
    }

];

console.log(Contacts);

/* -------------------------------
        AJOUTER UN ELEMENT
-------------------------------- */

var Couleurs = ['Bleu','Jaune','Vert','Orange'];

// -- Si je souhaite ajouter un élément dans mon tableau.
// -- Je fait appel à la fonction push() qui me renvoi le nombre d'éléments de mon tableau.

// -- NB : La Fonction unshift() permet d'ajouter un ou plusieurs éléments en début de tableau.

var nombreElementsDeMonTableau = Couleurs.push("Rouge");
console.log(Couleurs);
console.log(nombreElementsDeMonTableau);

/* --------------------------------------
    RECUPERER ET SORTIR LE DERNIER ELEMENT
-------------------------------------- */

// -- La fonction pop() me permet de supprimer le dernier élément de mon tableau et d'en récupérer la valeur.

// -- Je peux accessoirement récupérer cette valeur dans une variable.

var monDernierElement = Couleurs.pop();

// -- La même chose est possible avec le premier élément en utilisant la fonction shift();

// -- NB: La fonction splice() vous permet de faire sortir un ou plusieurs éléments de votre tableau.
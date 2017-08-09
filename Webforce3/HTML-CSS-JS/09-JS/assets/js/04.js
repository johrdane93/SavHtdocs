/* -------------------------------
    LES OPERATEURS ARITHMETIQUES 
-------------------------------- */

// ######## L'Addition ######## //

// -- Déclaration de plusieurs variable à la suite
var nb1, nb2, resultat;

nb1 = 10;
nb2 = 5;

// -- Addition de nb1 + nb2 avec l'opérateur "+"
resultat = nb1 + nb2;

// -- Affichage du résultat dans la console
console.log(resultat);

// ######## Soustraction ######## //

// -- Soustraction de nb1 - nb2 avec l'opérateur "-"
resultat = nb1 - nb2;

// -- Affichage du résultat dans la console
console.log(resultat);

// ######## Multiplication ######## //

// -- Multiplication de nb1 et nb2 avec l'opérateur "*"
resultat = nb1 * nb2;

// -- Affichage du résultat dans la console
console.log(resultat);

// ######## Division ######## //

// -- Division de nb1 et nb2 avec l'opérateur "/"
resultat = nb1 / nb2;

// -- Affichage du Résultat dans la Console.
console.log("Le Résultat de " + nb1 + " / " + nb2 + " est égal à : " + resultat);

// ######## Modulo ######## //

// -- NB : Le Modulo retourne le reste d'une division.

// -- Modulo de nb1 et nb2 avec l'opérateur "%"
nb1 = 11;
resultat = nb1 % nb2;

// -- Affichage du Résultat dans la Console.
console.log("Le Reste de la Division de " + nb1 + " par " + nb2 + " est égal à : " + resultat);

/* -------------------------------
    LES ECRITURES SIMPLIFIEES 
-------------------------------- */

nb1 = 15;
nb1 = nb1 + 5;
console.log(nb1);

nb1 += 5; // -- Ce qui équivaut à écrire nb1 = nb1 + 5;
// -- Ici, j'ai incrémenté et réaffecté.

console.log(nb1);

// -- Je peux procéder de la même manière pour tous les autres opérateurs arithmétiques : "+", "-", "/", "*", "%"
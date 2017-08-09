/* --
    Votre mission, que vous devez accepter !
    Réaliser une fonction permettant à un internaute de :
        - Saisir son Prénom dans un Prompt
        - Retourner à l'Utilisateur : Bonjour [PRENOM], Quel age as-tu ?
        - Saisir son Age
        - Retourner à l'Utilisateur : Tu est donc né en [ANNEE DE NAISSANCE].
        - Afficher ensuite un récapitulatif dans la page.
        Bonjour [PRENOM], tu as [AGE] ! 
-- */

// 1 -- Initialisation des variables
var DateDuJour = new Date();

// 2 -- Création de la Fonction
function Hello() {
    // 2a. Je demande à l'utilisateur son Prénom
    prenom = prompt("Hello ! What is your name ?","<Saisir votre Prénom>");

    // 2b. Je lui demande son age
    age = parseInt(prompt("Hello " + prenom + " ! How old are you ?","<Saisir votre Age>"));

    // 2c. J'affiche une alert avec son année de naissance !
    alert("AMAZING ! So you're born in " + (DateDuJour.getFullYear() - age) + " !");

    // 2d. Affichage dans ma page HTML
    document.write("Hello " + prenom + " it's AMAZING ! you're " + age + " years old !");
}

// 3 -- Execution de ma Fonction
Hello();
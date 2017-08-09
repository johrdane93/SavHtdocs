/* ------------------------------
  LES SELECTEURS D'ENFANTS jQUERY
------------------------------ */

// -- Initialisation de jQuery
$(function() {
    // -- Ici commence mon code jQuery
    // -- Les Flemards.js
    function l(e) {
        console.log(e);
    }

    // -- Je souhaite selectionner toutes mes sections
    l($('section'));

    // -- Je souhaite selectionner mon header
    l($('header'));

    // -- Si je souhaite tous les éléments (descendants direct (enfants)) qui sont dans "header"
    l($('header').children());

    // -- Je souhaite parmi mes descendants direct, uniquement les éléments de ma navigation (ul).
    l($('header').children('ul'));

    // -- Je souhaite récupérer tous les éléments "li" de mon "ul"
    l($('header').children('ul').find('li'));

    // -- Je souhaite récupérer uniquement le 2ème éléments de mes "li"
    l($('header').children('ul').find('li').eq(1));

    // -- Je souhaite connaitre le voisin immédiat de "header" ?
    l($('header').next());
    l($('header').next().next()); // -- Le voisin du voisin

    // -- LES PARENTS
    l($('header').parent());
});
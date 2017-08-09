/* ---------------------
  LES SELECTEURS jQUERY
---------------------- */

// -- Format : $('selecteur')
// -- En jQuery, tous les sélecteurs CSS sont disponibles...

// DOM READY !
$(function() {
    // -- Les Flémards.js
    function l(e) {
        console.log(e);
    }

    // -- Sélectionner les balises SPAN :

        // -- Version en Javascript :
        l("SPAN via JS :")
        l(document.getElementsByTagName('span'));

        // -- Version en jQuery
        l("SPAN via JQ")
        l($("span"));

    // -- Sélectionner mon Menu

        // -- Version en Javascript :
        l("ID via JS :")
        l(document.getElementById("menu"))

        // -- Version jQuery
        l('ID via jQuery')
        l($('#menu'))
        
    // -- Remarquez que jQuery me permet de sélectionner des éléments de façon beaucoup plus simple que javascript.

    // -- Sélectionner une Classe
        
        // -- Version Javascript
        l('Classe via JS :')
        l(document.getElementsByClassName('MaClasse'))
        
        // -- Version jQuery
        l('Classe via jQuery')
        l($('.MaClasse'))

        // -- Sélectionner par Attribut
        
        l('Par Attribut :')
        l($("[href='http://www.google.fr']")) // -- Attention aux guillemets.
        l($("[href]"))
});
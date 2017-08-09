/*----------------------------------------
LES SELECTEUR jQUERY
------------------------*/

// -- format :$^('selecteur')
// en jquery tout les selecteur css sont disponible


// DOM READY!
  $(function() {
  // --Les Flemards.js
    function l(e) {
    console.log(e);
     }

// -- selectionner les balise SAPN
  // -- version en JavaScript
    l("span via JQ");
    l($("span"));
   // selectionner mon menu

// -- version en JavaScript
l("ID via JS");

// -- Version jquery
l("ID via jQuery")
l($("#menu"))

/* remarquer que jQuery me permet de selectionner des element de facon beacoup plus simple que JavaScript*/

  // -- version de JavaScript
  l("class via js")
  l($('.MaClass'))

  // -Version de jquery
  l('class via JQuery')
  l($('.MaClass'))

  // --selecteur par atribut
  l("par attribut :")
  l($("[href='http://www.google.fr']"))
  l($("href"))

  

  });

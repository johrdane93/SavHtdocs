/* ---------------------
  DISPONIBILITE DU DOM
---------------------- */

// -- A partir du moment ou mon DOM, c'est à dire l'ensemble de l'arborescence de ma page est complètement chargé, je peux commencer à utiliser jQuery.

// -- Pour commencer à utiliser jQuery, je vais mettre l'ensemble de mon code dans une fonction.

// -- Cette fonction est appelé AUTOMATIQUEMENT par jQuery lorsque le DOM est entièrement défini.

// -- 3 façons de faire :

jQuery(document).ready(function() {
    // -- Ici, le DOM est entièrement chargé, je peux procéder à mon code JS.
});

// -- 2ème possibilité
$(document).ready(function() {
    // -- Ici, le DOM est entièrement chargé, je peux procéder à mon code JS.
});

// -- 3ème possibilité, sans le (document).ready
$(function() {
    // -- Ici, le DOM est entièrement chargé, je peux procéder à mon code JS.
    alert("Hello World !");

    // -- En Jquery
    $("#TexteEnJQuery").html("Mon texte en JQ");
    // -- En JS : 
    document.getElementById("TexteEnJQuery").innerHTML = "Mon texte en JS";
});
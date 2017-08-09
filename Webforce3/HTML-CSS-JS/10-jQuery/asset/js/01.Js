/*---------------------------------------------------------------------------------------------
         DISPONIBILITE DU NOM
-----------------------------------------------------------------------*/

/* -- a partire du moment  ou mon dom C'est aadire l'enssemble de l'arborescence de ma
page et compleyement chargé , je peut commencer a utiliser jquery*/

// -- Pour commencer a utiliser jquery ,je vais mettre l'enssemble de mon code dans une fonction.

// -- cette fonction est appelé AUTOMATIQUEMENT par jquery lorsque le DOM est entierement Defini.


// -- 3 facon de faire:

jQuery(document).ready(function(){
// -- ici le DOM et entierement charger, je peut proceder a mon code Js
  });


  // -- 2éme possibilité

  $(document).ready(function(){
    // -- ici le DOM et entierement charger, je peut proceder a mon code Js
  });
  // 3eme possibilit sans le (document).ready
  $(function(){
    // -- ici le DOM et entierement charger, je peut proceder a mon code Js
    alert("hello world !");

    // -- en jQuery
    $("#TextEnJQuery").html("mon Text En JQ");
    // --En JS :
    document.getElementById('TextEnJQuery').innerHTML = "Mon Text En Js";
  });

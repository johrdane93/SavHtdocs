/*--------------------------------------------------------------------------------
     LES SELECTEUR D'ENFANTS JQUERY
---------------------------------------------------------------------------------*/

//-- iNITIALISATION DE JQUERY
$function l(e) {
     console.log(e);

// -- je souhaite selectioner toutes mes sections
 l($('sections'));

 // --si je souhaite selectioner mon header
 l($("header"));

// -- si je souhaite que tout les element (decendants direct  (enfant )) qui sont dans "header"
 l($('header').children());

 // -- je souhaite parmi mes decendants direct , uniquement les element de ma navigation ( ul).
 l($('header').children('ul'));

 // -- je souhaite  recuperer tout les element  "li de mon "ul
 l($("header").children('ul').find('li'));

 // je souhaite recuperer uniquement le 2eme element de mes 'li'
 l($('header').children('ul').find('li').eq(1));

 //-- si je souhaite connaitre le voisin immédiat de "header"
     l($("header").next());
     l($("header").next()); --le voisin du voisin

    //  --LES PARENTS
    l($("header").parent());
 });

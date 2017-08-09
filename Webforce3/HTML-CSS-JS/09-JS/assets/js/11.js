/*-------------------------------------------------------------------------------------------------
-                                     Le DOM                                                      -
-              Le DOM, et un interface de dévlopement en JS Pour Html.                            -
-          Grace au DOM je vai être en mesure d'accéder / modifier mon HTML.                      -
-         L'objets "document" c'est mon point d'ntree vers mon contenu HTML !                     -
-          Chaque page charger dans mon naviguateur a un objet "document".                        -
-                                                                                                 -
-------------------------------------------------------------------------------------------------*/
// -- Allon faire un tour dans notre html ------>


// De retour dans notre js : comment puis-je-faire  pour RECUPERER les differante information dans ma page html



/*--------------------------------------------------------------------------------------------------
                                  documen.getElementById
                                    -------------------
    documen.getElementById() : C'est une fonction qui va permettre de RECUPERER un ELEMENT HTML
                             à partir de son identifiant unique : ID
------------------------------------------------------------------------------------------------------*/

var bonjour = documen.getElementById(Bonjour);
console.log(Bonjour); //--<p id="Bonjour">Paragraphe</p>


/*--------------------------------------------------------------------------------------------------
                                     documen.getElementsByClassName
                                        ------------------------
    documen.getElementByClassName() : C'est une fonction qui va permettre de RECUPERER un ou plusieurs ELEMENT (une liste) HTML
                             à partir de leur *classe*.
------------------------------------------------------------------------------------------------------*/

var contenu.getElementsByClassName("contenu");
console.log(contenu);
// -- Me renvoi : Un Tableau JS avec mes element HTML, ou encore autrement dit, une collection d'élément HTML.


/*--------------------------------------------------------------------------------------------------
                                     documen.getElementsByTagName
                                      -------------------------
    documen.getElementByTagName() : C'est une fonction qui va permettre de RECUPERER un ou plusieurs ELEMENT (une liste) HTML
                             à partir de leur *Nom de balise*.
------------------------------------------------------------------------------------------------------*/
documen.getElementsByTagName("span");
console.log(span);
//--

/*-------------------------------------------------------------------------------------------------------------
-                                                                                                                    




*/

/*---------------------------------------------------------------
      La manipulation des contenus
------------------------------------------------------------------*/
function w(write){
  write(write)
}
function l(log) {
    console.log(log);

}
// -- Je souhaite récupérer mon lien ; comment procéder ?
      var google = document.getElementById('google');
      l(google);

 // -- maintenant , je souhaite acceder aux information de ce lien , par exemple:

      //-- A : le lien vers le quel pointe la balise
           document.log('le lien vers le quel pointe la balise');
           ducument.log(google.href);

      // -- L'id de la balise
             l('l\'ID de la balise');
             l(google.id)


      // C: la class de la balise
         l('la class de la balise');
         l(google.className);

      // D: Le texte de la balise ( L'élément)
        l('Le texte de la balise');
        l('google.textContent');


// -- maintenant, je souhaite modifier le contenu de mon lien
// -- comme une variable classique, je vais simplement venir  affecter une nouvelle valeur.

 google.textContent="mon lien ver google";

/*---------------------------------------------------------------------------------------
-                        AJOUTER UN  ELEMENT DANS MA PAGE
--------------------------------------------------------------------------------------------*/

   //-- Nous Allon utiliser 2 méthode
    /*-- 1: La fonction document.creatElement() va permettre de générer un nouvel élément
     dans le DOM ; que je pourrais par la suit modifier avec les methode que nous venons de voir.*/
    // -- PS: Ce nouvel élémnt est placé en mémoire.

      // -- definition de mon élément
          var span  =  document.creatElement(span);

      // -- je souhaite lui donner une ID
          span.id="MonSpan";

      // -- je souhaite lui attribuer du contenu
          span.textContent ="Mon beau texte en JS.";

// --  2 la fonction appendChild() va me permettre de rajouter un enfant a un  élément du DOM.

       google.appendChild(span)

      /*-----------------------------------------------------------------------------------------------------------
-                                                EXERCICE
                            En partant du travail deja realiser sur la page.
                          creez directement dans la page une balise <h1></h1>
                              ayant comme contenu : titre de mon article
                    Dans cette balise, vous creerez un lien vers une url de votre choix
                           BONUS : Ce Lien sera de couleur rouge non souligné
---------------------------------------------------------------------------------------------------------------*/


    var h1  =  document.creatElement("h1");

    //--creation de la balise a
    var a = document.createElement("a");

      // je vais donner un titre a mon lien
       a.textContent =" titre de mon article"

      //  -- je veux donner un lien à mon lien
         a.href ="#";

      // -- appenChild()
      //   je met mon lien (a) dans mon h1
          h1.appendChild(a);

        // -- je met mon h1  dans ma page , dans mon body
        document.body.appendChild("h1");


      // -- je souhaite lui attribuer du contenu
           h1.textContent = "titre de mon article.";

// --  2 la fonction appendChild() va me permettre de rajouter un enfant a un  élément du DOM.

 google.appendChild(h1);



































// --

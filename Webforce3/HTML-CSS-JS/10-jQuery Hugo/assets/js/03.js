/* ------------------------------
  LE CHAINAGE DE METHODES jQUERY
------------------------------ */

$(function() {

    // -- Je souhaite cacher toutes les div de ma page HTML
    $('div').hide('slow', function() {
        // -- Une fois que la méthode hide() est terminée, mon alerte peux s'executer.
        alert('Fin du HIDE');

         // -- NOTA BENE : La fonction s'executera pour l'ensemble des éléments du selecteur.

         // -- CSS
         $('div').css("background","yellow");
         $('div').css("color","red");

        // -- Je fait réapparaitre mes DIV
        $('div').show();

        // -- En utilisant le chainage de méthode, vous pouvez faire s'enchainer plusieurs fonctions les unes après les autres, ...
        $('p').hide(2000).css('color','blue').css('font-size','20px').delay(2000).show(500);

        // -- MAIS, C'EST ENCORE TROP LONG !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        $('p').hide().css({'color':'blue','font-size':'20px'}).delay(2000).show();
    });

});
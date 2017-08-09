/*---------------------------------------------
Le Chainage de methodes jquery
-------------------------------*/
$(function() {
  //  -- je souhaite cacher toutes les div de ma page HTML
  $('div').hide("slow", function() {
    // -- une fois quze la methodes hide() est terminée, mon alerte peux s'executer.
    alert('Fin du HIDE');
    // -- NOTA BENE : La Fonction s'executera pour l'enssemble des element du selecteur.
      // --CSS
       $('div').css("background","yellow");
       $('div').css("color","red");
      //  -- je fait reapparaitre mes div
      $('div').show();
      // -- en utilisant le chainage d methode, vous pouvez faire s'enchainer plusieur Fonction les une apres les autre
      $('p').hide(2000).css('color','blue').css('font-size','20px').delay(2000).show(500);
      // -- MAIS, C'est encore trop long!!!!!!!!!!!!!!!!!!!
      $('p').hide().css({'color':'blue','font-size':'20px'}).delay(2000);

   });
});

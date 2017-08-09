/*---------------------------------------------------------------------------
-                         Les Boucle
----------------------------------------------------------------------------*/
//--la Boucle FOR


 //--pour i = 1 ; tant que i <= (strictement inferieur ou egale) 10 ; alors, j'incremente i de + 1;

 for(var i = 1 ; i <= 10; i++){
   document.write ("<p>Instruction executée :<Strong>" + i +" </Strong></p>")
 }
// -- SUBtilite
 var i =40;
i++ // affiche 40
 ++i // Affiche 41


document.write("hr");
//-- la Boucle while: tant que
  var j = 1;
   while (j <=10) {
    document.write ("<p>Instruction executée :<strong>"+ j +" </strong></p>")
     j++;
  }
/*----------------------------------------------------------------------------
-                            EXERCICE
--------------------------------------------------------------------------*/
  //-- supposon, le tableau suivant:
  var prenoms = ['Hugo','jean','matthieu','luc','pierre','marc'];
  for (var i=0; i < 6 ; i++) {
    console.log(prenoms[i]);
}

  //-- CONSIGNE: grace a une boucle FOR, afficher la liste des prenoms du tableau suivants dans la console ou sur votre page.

// -2eme facon de faire avec "length"
var NbElementDansMonTableau =prenoms.length;
for(var i=0 ;i < NbElementDansMonTableau ; i++) {
  console.log(prenoms[i]);
}

//--autre 

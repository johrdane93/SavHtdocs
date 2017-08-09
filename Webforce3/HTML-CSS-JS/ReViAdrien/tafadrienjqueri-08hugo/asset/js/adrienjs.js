$(function(){
 $('#contact').on('submit',function(a){
   a.preventDefault();
 $('#contact .has-error').removeclass('has-error');
   var nom, prenom, email, tel;
   nom     = $('#nom');
   prenom  = $('#prenom');
   email   = $('#email');
   tel     = $('#tel');

if(mon.val().length == 0){
  nom.parent().addClass('has-error');
}

// -- Vérification des informations...
var mesInformationsSontValides = true;

    // -- Vérification du Nom
    if(nom.val() == "") {
        nom.parent().addClass('has-error');/*has-error entour d'un cadre rouge les error*/
        //-- et je rajoute une indication texte.
        $("<p class='text-Danger'> n'oublier pas de saisir</p>").appendTo(nom.parent());

    }

    // -- Vérification du Prénom
    if(prenom.val().length == 0) {
        prenom.parent().addClass("has-error")
        $("<p class='text-Danger'> n'oublier pas de saisir</p>").appendTo(prenom.parent());

    }

    // -- Vérification du Téléphone
    if(tel.val().length == 0) {
        tel.parent().addClass("has-error")
        $("<p class='text-Danger'> n'oublier pas de saisir</p>").appendTo(tel.parent());

    }

    // -- Vérification de l'Email
    if(!validateEmail(email.val())) {
        email.parent().addClass("has-error")
        $("<p class='text-Danger'> n'oublier pas de saisir</p>").appendTo(email.parent());

    }

   });
});

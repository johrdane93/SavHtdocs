

    // -- Vérification de la validité d'un Email
    // : https://paulund.co.uk/regular-expression-to-validate-email-address
    function validateEmail(email){
        var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);

        var valid = emailReg.test(email);

        if(!valid) {
            return false;
        } else {
            return true;
        }
    }
        // --initialisation du jQuery
        $(function() {

              // -- Détection de la soumission de mon Formulaire
              $('#contact').on("submit", function(event) {
                  // -- event : corepoond ici à notre evenement 'submit'
                  // -- Arrêt de la propagation du submit(redirection)
                  e.preventDefault();

                  // -- réinitialisation des erreur
                  $("#contact .has-error").removeclass('has-error');
                  $('#contact .has-error').remove();

                  // -- DECLARATION des champs à vérifier
                  var nom, prenom, email, tel;
                  nom     = $('#nom');
                  prenom  = $('#prenom');
                  email   = $('#email');
                  tel     = $('#tel');

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

                  // -- Tous est correct, Préparation du Contact
                  if(mesInformationsSontValides) {
                      // -- Tous est correct, Préparation du Contact
                      var Contact = {
                          'nom'   :   nom.val(),
                          'prenom':   prenom.val(),
                          'email' :   email.val(),
                          'tel'   :   tel.val()
                      };

                    };
                });
              });

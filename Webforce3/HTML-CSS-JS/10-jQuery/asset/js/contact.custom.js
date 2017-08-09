// -- Initialisation de jQuery (DOM READY)
$(function() {

    // -- Déclaration de Variables
    var Contacts = [];

    /* --------------------------------------------------------------
                        DECLARATION DES FONCTIONS
    -------------------------------------------------------------- */

    // -- Fonction ajouterContact(Contact) : Ajouter un Contact dans le tableau de Contacts, mettre à jour le tableau HTML, réinitialiser le formulaire et afficher une notification.
    function ajouterContact(Contact) {

        // -- Ajout du "Contact" dans le Tableau "Contacts"
        Contacts.push(Contact); //console.log(Contacts);
        
        // -- On cache la phrase : aucun contact.
        $(".aucuncontact").hide();

        // -- Mise à jour du HTML
        $('#LesContacts').find('tbody').append('<tr><td>'+ Contact.nom +'</td><td>'+ Contact.prenom +'</td><td>'+ Contact.email +'</td><td>'+ Contact.tel +'</td></tr>');

        // -- Réinitialisation du Formulaire
        reinitialisationDuFormulaire();

        // -- Affichage d'une Notification
        afficheUneNotification();
    }

    // -- Fonction RéinitialisationDuFormulaire() : Après l'ajout d'un contact, on remet le formulaire à 0 !
    function reinitialisationDuFormulaire() {
        // -- En Javascript :
        document.getElementById("contact").reset();
        // -- En jQuery :
        $("#contact").get(0).reset();
    }

    // -- Affichage d'une Notification
    function afficheUneNotification() {
        $(".alert-contact").fadeIn().delay(3000).fadeOut();
    }

    // -- Vérification de la présence d'un Contact dans Contacts
    function estCeQunContactEstPresent(Contact) {
        // -- Booleen qui indique la présence ou pas d'un contact
        var estPresent = false;

        // -- On parcours le tableau à la recherche d'une correspondance
        for(i = 0 ; i < Contacts.length ; i++) {

            // -- Vérification pour chaque contact du tableau, s'il y a une correspondance avec mon Contact.
            if(Contact.email == Contacts[i].email) {
                // -- Si une correpondance est trouvé "estPresent' passe à VRAI (true)
                estPresent = true;
                
                // -- On arrête la boucle, plus besoin de poursuivre
                break;
            }
        }

        // -- On retourne estPresent
        return estPresent;
    }

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

    /* --------------------------------------------------------------
                    TRAITEMENT DE MON FORMULAIRE
    -------------------------------------------------------------- */

    // -- Détection de la soumission de mon Formulaire
    $('#contact').on("submit", function(e) {

        // -- Arrêt de la propagation du submit
        e.preventDefault();

        // -- Récupération des champs à vérifier
        var nom, prenom, email, tel;
        nom     = $('#nom');
        prenom  = $('#prenom');
        email   = $('#email');
        tel     = $('#tel');

        // -- Vérification des informations...
        var mesInformationsSontValides = true;

            // -- Vérification du Nom
            if(nom.val() == "") {
                mesInformationsSontValides = false;
            }

            // -- Vérification du Prénom
            if(prenom.val().length == 0) {
                mesInformationsSontValides = false;
            }

            // -- Vérification du Téléphone
            if(tel.val().length == 0) {
                mesInformationsSontValides = false;
            }

            // -- Vérification de l'Email
            if(!validateEmail(email.val())) {
                mesInformationsSontValides = false;
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

            // -- Vérification EstCeQunContactEstPresent ?
            if(!estCeQunContactEstPresent(Contact)) {
                // -- Ajout du Contact
                ajouterContact(Contact);
            } else {
                alert('ATTENTION\nMalheureusement, ce contact est déjà présent.');
                reinitialisationDuFormulaire();
            }

        } else {
            // -- Les Informations ne sont pas valides.
            alert("ATTENTION\nVeuillez bien remplir tous les champs."); 
        }

        // -- Ou, les Informations ne sont pas valides.

    }); // Fin du évènement submit
}); // Fin jQuery Ready
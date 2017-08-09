// /*-----------------------------------------------------------------------------
// -                                 La Consigne
// -               A partire du formulaire de contacte ci dessu
// -     1:afficher a l'utilisateur un recapitulatif de ca demande de contact.
// ------------------------------------------------------------------------------*/
//
// $('#MonFormulaire').on('submit',function(e){ moi dla merde
//
//   e.preventDefault();
//   $(this).replaceWith('<p> Bonjour Petit ' + $("#fullname").val() + ' </p> ' + 'Email : ' $('#Email').val() + "  " + 'Telephone : '
//   + $('#tel').val() + " " + 'Sujet :' + $('#Sujet').val() + " " + 'message : ' + $('#message').val() +''
//   );
// });             taf rudy


// $('#MonFormulaire').on('submit', function(e){
//    // -- J'annule l'action du submit
//    e.preventDefault();
//    $(this).replaceWith('Prénom et NOM : ' + $('#fullname').val() + '<br>' + '<br>' + ' Email : ' + $('#email').val() + '<br>' + '<br>' + ' Telephone : ' + $('#tel').val() + '<br>' + '<br>' + ' Sujet : ' + $('#sujet').val() + '<br>' + '<br>'  + ' Message : ' + '<br>' + '<br>' + $('#message').val());
// });


// ---TAF Hugo

// --1 Attendre que le dom soit charge.
 $(function(){
    // --2 : Ecouter l'evenement "Submit du formulaire.
    $('#MonFormulaire').on('submit',function(a){
      // --3 : Stopper l'envoi du formulaire
      a.preventDefault();
      // --4: Récuperation des Informations
      fullname =$("#fullname").val()
      email    =$('#email').val()
      tel      =$('#tel').val()
      Sujet    =$('#sujet').val()
      message  =$('#message').val()
// -- 5 : Récapitulatif
 $(this).replaceWith("<p> Bonjour <Strong>" + fullname + "</Strong><em> (" + email + ")</em> <br><br>Vous nous avez contacter au sujet de : <Strong>" + Sujet + "</Strong>.<br>Nous reviendrons vers vous dans les plus bref delais au <Strong>" + tel + "</Strong><br><br><u>Ci-dessou votre message : </u><br>" + message + "</p>");
    });
 });

$(function(){
  $('p').click(function(){
    $(this).hide();
  });
});
// -- En JQ
$('#MonFormulaire').on('submit',function(e){
  // --Jannule l'action du submit
  e.prevenDefault();
  $(this).replacewith('<p>Bonjour Petit ' + $("#nomcomplet").val() + '! </p>')
});

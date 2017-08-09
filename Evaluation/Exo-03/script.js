$(function () {

//Function pour recupéré les données du formulaire
$('.create_auto').on('submit', function (e) {

  //Retrait du comportement par default du submit
  e.preventDefault();

  //On stock les données du form dans une variable
  var datas = $(this).serializeArray();

  //On prepare le JSON
  var formatDatas = {};

  //On boucle les données pour les stockées dans un tableau
  for (var i = 0; i < datas.length; i++) {
    formatDatas[datas[i]['name']] = datas[i]['value'];
  }

  //on appel la method ajax
  createAuto(formatDatas);
});

//On créer la requete AJAX
var createAuto = function(credentials) {


  $.ajax({
    method: 'POST',
    url: 'http://localhost/Evaluations_WF3/Exo_3/read.php',
    data: credentials,
    success: function(response) {
      if (response.success) {
        $('.return').append("Reussite");
      } else {
        $('.return').append("Echec");
      }

    }
  });

}

});

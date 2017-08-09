$(function() {

  //****************** début page accueil **********************************

  $('#select_categorie').change(function() {

    $.post("./inc/api.php", $('#form_filtres_gauche').serialize()).done(function(data) {

      $('#annonces').empty();
      data = JSON.parse(data);
      for (var i = 0; i < data.length; i++) {
        $('#annonces').append(
          '<div class = "panel panel-default"><a href="fiche_annonce.php?id_annonce=' + data[i]['id_annonce'] + '"><h4 class = "text-center" >' + data[i][
            'titre'
          ] +
          '</h3><div class = "panel-body"><img src =""                alt = ""><span>' +
          data[i]['description_courte'] + '</span><br><span>' + data[i]['pseudo'] +
          ' ' + data[i]['note'] + '</span><span>' + data[i]['prix'] +
          '</span></a></div>'
        );
      };

    });


  });

  $('#select_membre').change(function() {

    $.post("inc/api.php", $('#form_filtres_gauche').serialize()).done(function(data) {

      $('#annonces').empty();
      data = JSON.parse(data);
      for (var i = 0; i < data.length; i++) {
        $('#annonces').append(
          '<div class = "panel panel-default"><a href="fiche_annonce.php?id_annonce=' + data[i]['id_annonce'] + '"><h4 class = "text-center" >' + data[i][
            'titre'
          ] +
          '</h3><div class = "panel-body"><img src =""                alt = ""><span>' +
          data[i]['description_courte'] + '</span><br><span>' + data[i]['pseudo'] +
          ' ' + data[i]['note'] + '</span><span>' + data[i]['prix'] +
          '</span></a></div>'
        );
      };

    });


  });

  // ************************** fin page accueil ***************************************



})

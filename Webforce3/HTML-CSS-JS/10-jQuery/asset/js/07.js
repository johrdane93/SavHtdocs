//detection de la soumission de mon formulaire
$('#contact').on("submit",function(e) {
  //-- arret de la propagation du submit
   e.preventDefault();

   //recuperation des champs a vérifier
     var nom , premon , email , tel;
        nom    =$("nom");
        premon =$("prenom");
        email =$("email");
        tel    =$("tel");
//--verification de information
     var MesInfomationSontValides = true;

//-- verification du nom
// if(nom.val()== "") {}ou
if(nom.val().lenght == 0){
  MesInfomationSontValides = false;
}
//-- verification du prenom
if(prenom.val().lenght == 0){
  MesInfomationSontValides = false;
}
//-- verification du email
if(email.val().lenght == 0){
  MesInfomationSontValides = false;
}
//-- verification du telephone
if(tel.val().lenght == 0){
  MesInfomationSontValides = false;
}

//  validation de la validiter de l'emazil
function validateEmail(email){
	var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	var valid = emailReg.test(email);

	if(!valid) {
        return false;
    } else {
    	return true;
    }
}
//  tout et correct , preparation du contact
  if(MesInfomationSontValides){
    //--tout et correct, preparation du contact
    var contact = {
       'nom'   : nom.val(),
       'premon' : prenom.val(),
       'email' : email.val(),
      ' tel'    : tel.val()
};
//--ajoutter le contact
AjouterContact(contact);

  }else {
      //-- les information  ne sont pas valider
      alert(" ATTENTIO\nVeuillez bien remplire tous les champ.");
  }
// -- afficherez l'ensemble de mes info contacts sur tableau sur ma page HTML
// 1er methode relou
//$("#contact > tbody:last");


  // --2eme methode La dite LA Torture mentale!!
  // function addRow(){
  //
  // 		var cell, ligne;
  //
  // 	    // on récupère l'identifiant (id) de la table qui sera modifiée
  // 	    var tableau = document.getElementById("contact");
  // 	    // nombre de lignes dans la table (avant ajout de la ligne)
  // 	    var nbLignes = tableau.rows.length;
  //
  // 	    ligne = tableau.insertRow(-1); // création d'une ligne pour ajout en fin de table
  // 	                                   // le paramètre est dans ce cas (-1)
  //
  // 	    // création et insertion des cellules dans la nouvelle ligne créée
  // 	    cell = ligne.insertCell(0);
  // 	    cell.innerHTML = "Ligne " + nbLignes + " Cellule 0";
  //
  // 	    cell = ligne.insertCell(1);
  // 	    cell.innerHTML = "Ligne " + nbLignes + " Cellule 1";
  //
  // 	    cell = ligne.insertCell(2);
  // 	    cell.innerHTML = "Ligne " + nbLignes + " Cellule 2";
  //
  // 	    cell = ligne.insertCell(3);
  // 	    cell.innerHTML = "Ligne " + nbLignes + " Cellule 3";
  //
  // 	    cell = ligne.insertCell(4);
  // 	    cell.innerHTML = '<a class="btn btn-info" href="#" ><i class="icon-edit icon-white"></i></a> <a class="btn btn-danger" href="#" onclick="deleteRow();"><i class="icon-trash icon-white"></i></a>' ;
  // 	}

// -- Methode HuGo

function AjouterContact(contact) {
  //-- Ajour du contact dans le tableau
  contact.push(contact); //  console.log(contact);
 //  --on cache la phrase aucun contact
 $(".aucuncontact").hide();
 //--mise a jour du html
 $(".LesContacts").find("tbody").append('<tr></tr>'+ contact.nom + '<tr></tr>' + contact.prenom + '<tr></tr>' + contact.email + '<tr></tr>' + contact.tel +'<tr></tr>');

}

// -- fonction reinitialisationDuFormulaire(): aprész l'ajout d'un contact , on remet le formulaire à 0 {
function reinitialisationDuFormulaire() {
  // $("#reset").on(function() {
  //         $("#LesContacts")[0].reset();
  //      });
  //-- en java script
  document.getElementById(0).reset(0);
  //-- en jquery
  $("#contact").get(0).reset();
}









});

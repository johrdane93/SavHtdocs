<?php

//*********************Traitement************************
require_once('inc/init.inc.php');
$inscription= false;// pour ne pas afficher le formulaire une fois le membre inscrit

debug($_POST);
// Trzitement du formulaire
if(!empty($_POST)){
  //Controles:
  if(strlen($_POST['pseudo']) < 4|| strlen($_POST['pseudo']) >20){
    $contenu .= '<div class="bg-danger">Le pseudo doit contenir entre 4 et 20 caractéres.</div>';
  }
  if(strlen($_POST['mdp']) < 4|| strlen($_POST['mdp']) >20){
    $contenu .= '<div class="bg-danger">Le mdp doit contenir entre 4 et 20 caractéres.</div>';
  }
  if(strlen($_POST['nom']) < 2|| strlen($_POST['nom']) >20){
    $contenu .= '<div class="bg-danger">Le nom doit contenir entre 4 et 20 caractéres.</div>';
  }
  if(strlen($_POST['prenom']) < 2|| strlen($_POST['prenom']) >20){
    $contenu .= '<div class="bg-danger">Le prenom doit contenir entre 4 et 20 caractéres.</div>';
  }
if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
  $contenu .= '<div class="bg-danger">email invalide</div>';
  //filter_var permet de valider un format d'email avec l'option FILTER_VALIDATE_EMAIL.On peut aussi valider les url ave FILTER_VALIDATE_URL
  }
  if (!isset($_POST['civilite'])|| ($_POST['civilite'] != 'm' && $_POST['civilite']!= 'f')) {'<div class="bg-danger">Erreur de civilite.</div>';
  }
  if(strlen($_POST['ville']) < 1|| strlen($_POST['ville']) >20){
    $contenu .= '<div class="bg-danger">La ville doit contenir entre 1 et 20 caractéres.</div>';
  }
if (!preg_match('#^[0-9]{5}$#',$_POST['code_postale'])) {
  $contenu .= '<div class"bg-danger">le code postale n\'est pas valide</div>';
}// la fonction preg_match verifie que la chaine de caractaire contenue dans le code postale correspond a l'expression regulière . en cas de succès, elle renvoie 1, sinon elle renvoie 0 .

/* l'expression reguliere utilisee :
    -Elle et encadree pas des # (délimiteurs)
    -le ^ signifit "commence par ce qui suit"
    -Le $ signifit "ce termine par ce qui precede"
    -entre crochet on definit l'intervale de lettre ou de chiffre autorises
    -entre accolade on quantifie le nombre de chiffre souhaités, ici 5 obligatoirement (quantificateur)
*/
if(strlen($_POST['adresse']) < 4|| strlen($_POST['adresse']) >50){
  $contenu .= '<div class="bg-danger">L\'adresse doit contenir entre 4 et 50 caractéres.</div>';
}
//si pas d'Erreur sur le formulaire, on verifie que le pseudo est unique:
if(empty($contenu)){
  //si le $contenue et vide il, ny a pas d'Erreur
  $membre = executeRequete('SELECT * FROM membre WHERE pseudo = :pseudo', array(':pseudo' =>$_POST['pseudo']));
if ($membre->rowCount()>0) {
  // si la requete renvoie des lignes c'est que le pseudo existe!
  $contenu .= '<div class="bg-danger">pseudo indisponible, veuillez en choisir un autre !</div>';
}else {
  // si la requete ne ne contien pas de ligne, le pseudo est disponible  : on l'insere en bdd:
  $_POST['mdp']=md5($_POST['mdp']);
  executeRequete('INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse,statut)VALUES(:pseudo, :mdp, :nom, :prenom, :email,:civilite, :ville, :code_postale, :adresse,0)',array(':pseudo'=>$_POST['pseudo'],':mdp'=>$_POST['mdp'],':nom'=>$_POST['nom'],':prenom'=>$_POST['prenom'],':email'=>$_POST['email'],':civilite'=> $_POST['civilite'],':ville' =>$_POST['ville'],':code_postale'=>$_POST['code_postale'], ':adresse'=>$_POST['adresse']));
}
}
}



//----------------------Affichage----------------------------
require_once ('inc/haut.inc.php');
echo $contenu; //pour afficher les message
if (!$inscription):
// si membre non inscrit on affiche le formulaire
?>
<form  action="" method="post"><br>
<label for="pseudo">pseudo</label>
<input type="text" name="pseudo" id="peuso" value="<?php if (isset($_POST['pseudo'])) echo $_POST['pseudo'];?>" ><br><br>

<label for="mdp">Mot de Passe</label><br>
<input type="password" name="mdp"  id="mdp" value="<?php if (isset($_POST['mdp'])) echo $_POST['mdp'];?>"><br><br>


<label for="nom">Nom</label><br>
<input type="text" name="nom"  id="nom" value="<?php if (isset($_POST['nom'])) echo $_POST['nom'];?>"><br><br>

<label for="prenom">Prenom</label><br>
<input type="text" name="prenom"  id="prenom" value="<?php if (isset($_POST['prenom'])) echo $_POST['prenom'];?>"><br><br>


<label for="email">Email</label><br>
<input type="text" name="email"  id="email" value="<?php if (isset($_POST['email'])) echo $_POST['email'];?>"><br><br>

<label>Civilite</label><br>
<input type="radio" name="civilite"  id="homme" value="m" checked><label for="homme">Homme</label><br>

<input type="radio" name="civilite"  id="femme" value="f" checked><label for="femme">Femme</label><br><br>

<label for="ville">Ville</label><br>
<input type="text" name="ville"  id="ville" value="<?php if (isset($_POST['ville'])) echo $_POST['ville'];?>"><br><br>

<label for="code_postale">Code postale</label><br>
<input type="text" name="code_postale"  id="code_postale" value="<?php if (isset($_POST['code_postale'])) echo $_POST['code_postale'];?>"><br><br>

<label for="adresse">Adesse</label>
<textarea name="adresse" id="adresse"> <?php if (isset($_POST['adresse'])) echo $_POST['adresse'];?></textarea>

<input type="submit" name="inscription" value="s'inscrire" class="btn">
</form>






<?php
endif;
require_once( 'inc/bas.inc.php');

<?php
 echo '<br>';echo '<hr>';
//-------------------------------------------------
//                 PDO
//---------------------------------------
//l'extension PDO pour Php Data Object,definit une interface pour acceder a une base de donnees depuis PHP.
 echo '<br>';echo '<hr>';
//-----------------------------------------------------------------
       echo '<h3>01.PDO : connexion</h3>';
//--------------------------------------------------------------

$pdo = new PDO('mysql:host=localhost;dbname=entreprise','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
// pdo est issu de la class predefini PDO : il represente la connexion à la base de donnees.
// Les arguments : 1 driver mysql + serveur + base de donnees -2 pseudo-3 mdp - 4 option 1 pour généré l'affichage  des erreur , option 2 definit le jeu de caractére des echange de la bdd.


echo' <pre>'; print_r($pdo); echo '</pre>';// on voit un objet de la class pseudo
echo' <pre>'; print_r(get_class_methods($pdo)); echo '</pre>';//affiche  lees methode de l'objet issu de la class pdo

 echo '<br>';echo '<hr>';
//-----------------------------------------------------------------
       echo '<h3>02.exec evec INSERT, UPDATE et DELETE</h3>';
//--------------------------------------------------------------
$resultat = $pdo->exec("INSERT INTO employes(prenom,nom,sexe,service,date_embauche,salaire)VALUES('test','teste','m','test','2016-02-08',500)");

/*exec() est utliser pour la formulation de requetes  ne retournant pas de jeux de resulte ( selet *from employe ): INSERT, UPDATE et DELETE

                Valeur de retour:
                  succes: un integer (= le nombre de ligne affectees)
                  Echec : false
*/
 echo "Nombre d'enregistrement affectes par L'INSER : $resultat <br>" ;
 echo "Dernier id généré lors de l'INSERT: " . $pdo->lastInsertId();
//-------
$resultat = $pdo->exec("UPDATE employes SET salaire =6000 WHERE id_employes = 350");
echo "nombre d'enregistrement affecter  par L'UPDATE: $resultat <br>";

 echo '<br>';echo '<hr>';
//-----------------------------------------------------------------
       echo '<h3>03.query avec SELECT + FETCH_ASSOC</h3>';
//--------------------------------------------------------------
$result = $pdo->query("SELECT * FROM employes WHERE prenom = 'daniel'");
/*
Au contraire d'exec(), query() est utiliser avec les requête retournant un ou plusieur résultat : SELECT.
        Valeur de retour:
          succes: on obtien un nouvel objet issu de la class predefinie PDOStatement( )
          Echec : FALSE
Noter que query peut être utilisé avec INSERT ,UPDATE & DELETE.
*/
echo' <pre>'; print_r($result); echo '</pre>';// affiche l'objet PDOStatement
echo' <pre>'; print_r(get_class_methods($result)); echo '</pre>';// affiche les méthode issues de la class PDOStatement

//$result et le resultat d'une requet  sous forme inexploitable directement : il ffaut donc le transformer par la methode fetch()
$result = $pdo->query("SELECT * FROM employes WHERE prenom = 'Thomas'");

$employe = $result->fetch(PDO::FETCH_ASSOC);// la methode fetch() acec le parametre PDOPDO::FETCH_ASSOC permet nde changer l'objet  $result en un array associatif  ($employe) indexé zvec le nom des champs de la requetes

echo '<hr>';//


echo' <pre>'; print_r($employe); echo '</pre>';
echo"Je suis  $employe[prenom] $employe[nom] du service $employe[service] <br>";// on peut afficher le contenue de l'array  avec des crochet. remarque ici notre array est dans des Guillemets, il perd donc ses quotes autour des indices

// On peut transformer $result selon l'un des autre methode suivantes:
 $result = $pdo->query("SELECT * FROM employes WHERE prenom = 'Thomas'");
 $employe =$result->fetch(PDO::FETCH_NUM);// on obtien un array indexé numeriquement
 echo' <pre>'; print_r($employe); echo '</pre>';
 echo $employe[1].'<br>';// on affiche le prenom en passant par l'indices1 correspondant

echo '<hr>'; //-------

 $result = $pdo->query("SELECT * FROM employes WHERE prenom = 'Thomas'");
 $employe = $result->fetch();// fetch( sans argument fait un melange de FETCH_ASSOC et de FETCH_NUM)
 echo' <pre>'; print_r($employe); echo '</pre>';
 echo $employe['prenom'].'<br>';
 // ou
echo $employe[1].'<br>';

echo '<hr>'; //-------

$result = $pdo->query("SELECT * FROM employes WHERE prenom = 'Thomas'");
$employe = $result->fetch(PDO::FETCH_OBJ);// retourne un objet avec le nom des champ de la requetes comme proprietes(=attribut)publique
 echo' <pre>'; print_r($employe); echo '</pre>';
 echo $employe->prenom.'<br>'; // comme employe est un objet ,  on utilise la notation avec fleche ->

 // il faut choisir l'un des traitement fetch que vous voulez effectuer car vous ne pouvez pas en faire plusieur sur le même résultat.

echo '<hr>'; //-------
 //: exercice :afficher le service de l'employe dont l'id_employes est 417
 $result = $pdo->query("SELECT * FROM employes WHERE id_employes =417");
 $employe = $result->fetch(PDO::FETCH_OBJ);
echo' <pre>'; print_r($employe); echo '</pre>';
echo $employe->service.'<br>';

echo' <pre>'; print_r($donnees); echo '</pre>';

 echo '<br>';echo '<hr>';
//-----------------------------------------------------------------
       echo '<h3>04 while et FETCH_ASSOC</h3>';
//--------------------------------------------------------------

// jusqu'ici il n'y avait qu'un seul resultat  dans l'objet PDOStatement issu de la requête . pour traiter plusieur résultat , il nous faut faire une boucle while.

$resultat = $pdo->query("SELECT * FROM employes");
echo 'Nombre d\'employes dans la requete: ' .$resultat->rowCount() . '<br>';// retourne le nombre de ligne dans la requetes
while ($contenu = $resultat->fetch(PDO::FETCH_ASSOC)) {//fetch retourne la ligne suivante du jeu de resultat contenu dans $resultat en un array associatif La boucle table.La boucle s'arrête à la fin du resultat.
  //cho' <pre>'; print_r($contenu); echo '</pre>';
  echo '<div>';
        echo $contenu['id_employes'] . '<br>';
        echo $contenu['prenom'] . '<br>';
        echo $contenu['service'] . '<br>';
  echo'----------------------------</div>';
}
// remarque : il n'y a pas un seul array avec touts les enregistrement , mais un array p  ar employé
// Quand vous avez potentiellement plusieur resultat: Vous faite une boucle while sinon  vous faite un seul fetch.

 echo '<br>';echo '<hr>';
//-----------------------------------------------------------------
       echo '<h3>05. fetchAll</h3>';
//--------------------------------------------------------------

$resultat = $pdo->query("SELECT * FROM employes");
$donnees = $resultat -> fetchAll(PDO::FETCH_ASSOC);// retourne toute les ligne du resultat dans un tableau multidimensionnel : on a 1 array associatif à chaque indice numérique representant  un employes. Marche aussi avec PDO::FETCH_NUM.

echo' <pre>'; print_r($donnees); echo '</pre>';
// pour afficher tout le  contenue de cette array multidimensionnel , nous faisons des  boucle foreach imbriquees:

echo '<hr>';

foreach ($donnees as $employe ) {

  foreach ($employe as $indice => $valeur) { // cette boucle parcourt toutes les info du sous array representant 1 employe
    echo $indice .':'.$valeur . '<br>';
  }
  echo'------------------------<br>';

}

echo '<br>';echo '<hr>';
//-----------------------------------------------------------------
      echo '<h3>06.Exercie</h3>';
//--------------------------------------------------------------
// Affichez la liste des differants services ,en la mettant dans une liste <ul><li>.

echo'<ul>';
$resultat = $pdo->query("SELECT distinct service FROM employes");//--

echo 'Nombre de service: ' .$resultat->rowCount() . '<br>';

while ($contenu = $resultat->fetch(PDO::FETCH_ASSOC)) {
  echo '<div>';
        echo'<li>';
        echo $contenu['service'] . '<br>';
        echo'</li>';
  echo'----------------------------</div>';
  echo'</ul>';
}
// acev FETCH_ASSOC
echo '<hr>';

$resultat = $pdo->query("SELECT distinct service FROM employes");
echo'<ul>';
while ($donnees = $resultat->fetch(PDO::FETCH_ASSOC)) {

echo '<li>'.$donnees['service'].'</li>';

echo'</ul>';
}
echo '<hr>';
//----avec FETCH_ALL
$resultat = $pdo->query("SELECT distinct service FROM employes");
echo'<ul>';
$donnees = $resultat->fetchAll(PDO::FETCH_ASSOC);
foreach ($donnees as $value) {
echo '<li>'.$value['service'].'</li>';
echo'</ul>';
}

echo '<br>';echo '<hr>';
//-----------------------------------------------------------------
      echo '<h3>07.Table HTML</h3>';
//--------------------------------------------------------------


$resultat =$pdo->query("SELECT * FROM employes");

echo'<table border="1">' ;
//affichage de la ligne des entêtes:
echo'<tr>';
for($i=0;$i<$resultat->columnCount();$i++){// fait autant de tours de boucle qu'il y a de colonnes dans le jeu de resultat
//echo'<pre>'; print_r($resultat->getColumnMeta($i));echo '</pre>';// on voit que getColumnMeta retourne un array qui contient l'indice name avec le nom du champ de la table sql
$colonne=$resultat->getColumnMeta($i);//$collone est donc un array avec dadans l'indice name

echo '<th>'.$colonne ['name'] .'</th>';// on affiche le nome de la collone

}

echo'</tr>';
// affichage des ligne de la table :
while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)){
echo'<tr>';
      foreach ($ligne as $information){
        echo'<td>' . $information.'</td>';
      }



echo'</tr>';

}
echo '</table>';

echo '<br>';echo '<hr>';
//-----------------------------------------------------------------
      echo '<h3>08.prepar, bindparam,execute</h3>';
//--------------------------------------------------------------

$nom ='sennard';
//preparation de la requéte:
$resultat= $pdo->prepare("SELECT * FROM employes WHERE nom =:nom");//prépare la requête avec un marqueur nominatif qui attend une valeur

// 2- On lie le marqueur à une variable :
$resultat->bindparam(':nom',$nom,PDO::PARAM_STR);// bindparam recoit exclusivement  une variable vers laquelle pointe le marqueur : ici on lie le marqueur nim à la variable $nom . ainsi , si le contenue de la Variable change, la valeur du marqueur changera automatiquement lorsqu'on refera un execute . On a aussi Les constantes PDO::PARAM_INT et PDO::PARAM_BOOL

//3- On execute la requête
$resultat->execute();
//4 -fetch:
$donnees = $resultat->fetch(PDO::FETCH_ASSOC);
echo implode($donnees,' - ');// implode transforme le contenu d'un array en string

/*
prepare() permet de preparer la requetes mais ne l'execute pas .
execute() permet  d'executer une requéte preparée.
      valeur de retour:
        prepare() renvoie toujoure un objet PDOStatement
        execute() :
                  succes :true
                  echec :false

Les requetes preparees sont, preconisée vous executez plusieur fois la même requéte, et ainsi vouloir eviter de répéter le cycle complet : analyse / interprétation/exécution.
Les requéte preparées sont aussi utilisées poue assainir les donnees(prepare +bindparam +execute).
*/

//si on change le contenue de la variable $nom ,il n'est pas nécessaire de refaire un bindparam avant un nouvel  execute .
echo '<br>';echo '<hr>';
$nom ='durand';
$resultat->execute();
$donnees = $resultat->fetch(PDO::FETCH_ASSOC);
echo implode($donnees,' - '); // on obtient bien les infos de durant




echo '<br>';echo '<hr>';
//-----------------------------------------------------------------
      echo '<h3>09.prepar, bindValue,execute</h3>';
//--------------------------------------------------------------
//1-. preparation de la requetes:
$resultat =$pdo->prepare("SELECT * FROM employes WHERE nom = :nom");

//2-je lie le marqueura une valeur :
$resultat->bindValue(':nom','thoyer',PDO::PARAM_STR);

//3- On execute la requéte:
$resultat->execute();

//4-fetch
$donnees = $resultat->fetch(PDO::FETCH_ASSOC);

echo implode($donnees,'-');

echo '<br>';echo '<hr>';
//-----------------------------------------------------------------
      echo '<h3>10.Exercice</h3>';
//--------------------------------------------------------------

//*afficher dans une liste ul li le titre des livre empruntés par chloé en utilisant une requête  preparees.


//1-connection a la BDD
$pdo = new PDO('mysql:host=localhost;dbname=bibliotheque','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

//2-La requete:
$resultat = $pdo->prepare("SELECT titre FROM livre WHERE id_livre IN(SELECT id_livre FROM emprunt WHERE id_abonne IN(SELECT id_abonne FROM abonne WHERE prenom = :prenom))");

$prenom ='Chloe';
$resultat->bindParam(':prenom',$prenom,PDO::PARAM_STR);
$resultat->execute();

//3-fetch:
echo '<ul>';
while ($donnees = $resultat->fetch(PDO::FETCH_ASSOC)){
echo '<li>'. $donnees['titre'].'</li>';
}
echo '</ul>';


echo '<br>';echo '<hr>';
//-----------------------------------------------------------------
      echo '<h3>11.point complementaires</h3>';
//--------------------------------------------------------------
 echo'<strong>Le marqueur"?"</strong>';

  $pdo = new PDO('mysql:host=localhost;dbname=entreprise','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

$resultat=$pdo->prepare("SELECT * FROM employes WHERE nom =? AND prenom = ?");//on prepare la requête sans les variables que l'on remplace par des marqueur "?"
 $resultat->execute(array('durand','damien'));
 $donnees = $resultat->fetch(PDO::FETCH_ASSOC);// pas de boucle while car je suis certain qu'il n'y qu'un resultat dans la requete.$donnees est un array  associatif.

 echo'<br>service :'. $donnees['service'].'</br>';

 echo'<strong>execute Sans bindparam:</strong>';
 $resultat=$pdo->prepare("SELECT * FROM employes WHERE nom =:nom AND prenom = :prenom");
 $resultat->execute(array(':nom'=>'durand',':prenom'=>'damien'));//Nous associon les marqueurs nominatifs dan sun array associatif passé en arguments de execute . Notez que vous n'ête pas oblige de mettre les : avant le nom des marqueur dans l'array en arguments de execute

 $donne = $resultat->fetch(PDO::FETCH_ASSOC);
 echo '<br>Service :'.$donnees['service'].'<br>';





//////

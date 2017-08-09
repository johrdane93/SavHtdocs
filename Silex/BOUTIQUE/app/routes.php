<?php


// //Code ajouté à l'etape 6.3
// $app -> get('/', function(){
// 	require '../src/model.php';
// 	// Fichier qui contient la fonction afficheAll()
//
// 	$infos = afficheAll();
//
// 	$produits = $infos['produits'];
// 	$categories = $infos['categories'];
// 	// on récupère les infos de notre fonction afficheAll()
//
// 	ob_start();
// 	require '../views/view.php';
// 	$view = ob_get_clean();
// 	return $view;
// 	// Stocke dans la variable $view notre vue, puis on la retourne... (base de la méthode render())
// });

$app -> get('/', function() use($app){
  $produit = $app ['dao.produit'] -> findAll();
  $categories = $app ['dao.produit'] -> findAllCategorie();

	$params = array(
		'produit'   => $produit,
		'categories' => $categories
	);
	return $app['twig'] -> render('index.html.twig',$params);
})-> bind('home');//le nom de cette route et 'home';




//Exercice : Ajoueter la page boutique:
$app -> get ('/boutique/{categorie}',function($categorie) use($app){
	$produit = $app ['dao.produit'] -> findAllByCategorie($categorie);
	$categories = $app ['dao.produit'] -> findAllCategorie();

	$params = array(
		'produit'   => $produit,
		'categories' => $categories
	);

return $app['twig'] -> render('boutique.html.twig',$params);
//rendre la vue boutique.html.twig (index.html)
})-> bind('boutique');//le nom de cette route et 'home'
// Exercice2 ajouter la page produit


$app -> get('/produit/{id}', function($id) use($app){
 $produit = $app['dao.produit'] -> find($id);
 $suggestions = $app['dao.produit'] -> findSuggestions($id);
 $params = array(

   'produit' => $produit,
   'suggestions' =>$suggestions,
   ' commentaires' => $commentaires
 );
 // rendre la vue boutique.html.twig
 return $app['twig'] -> render('produit.html.twig', $params);
 // test : www.boutique.dev/produit/5

})-> bind('produit');

$app -> get('/profil/{id}',function($id) use($app){
  // recuperer les info d'un produit grace à sont id
  $membre = $app ['dao.membre'] -> find($id);

  $params = array(
		'membre'   => $membre,
    'title' => 'Profil de ' . $membre -> getPseudo()
	);

  return $app['twig'] -> render ('profil.html.twig',$params);

})-> bind('profil');


//ex4
$app -> get('/login/',function() use($app){
  // recuperer les info d'un produit grace à sont id

$params = array(
    'error' => $app['security.last_error']($request),
     'last_username'=>$app['session'] -> get('security.laste_username')
);

  return $app['twig'] -> render ('login.html.twig',$params);

})-> bind('login');

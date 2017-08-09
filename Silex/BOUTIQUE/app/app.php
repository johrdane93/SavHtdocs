<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

// enregistrement des services error et Exception
ErrorHandler::register();
ExceptionHandler::register();

//on enregistre notre application au services doctrine
$app -> register (new Silex\Provider\DoctrineServiceProvider());

//on enregistre notre application au services TWIG
$app -> register (new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views'
));
// On enregistre notre application au service asset :
$app -> register (new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1'


));

//on enregistre dans $app['dao.produit'] notre objet de la classe produitDAO De cette maniere quand on en aure besoin, on utilisera $app['dao.produit']
$app['dao.produit'] = function($app){
  return new BOUTIQUE\DAO\ProduitDAO($app['db']);
};
//on enregistre dans $app['dao.membre'] notre objet de la classe MembreDAO De cette maniere quand on en aure besoin, on utilisera $app['dao.membre']
$app['dao.membre'] = function($app){
  return new BOUTIQUE\DAO\MembreDAO($app['db']);
};

$app ['dao.membre'] = function($app){
  return new BOUTIQUE\DAO\MembreDAO($app['db']);
};
// on enregistre $app['dao.commmentaire'] notre objet de la classe commmentaireDAO. de cette  maniere on aura besoin, on utilisera $app['dao.commmentaire']
 $app['dao.commmentaire'] = function($app){
   $commentaireDao = new BOUTIQUE\DAO\CommentaireDAO($app['db']);
   $commentaireDao = setProduitDao($app['dao.produit']);
   return $commmentaireDAO;

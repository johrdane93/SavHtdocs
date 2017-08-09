<?php

require_once __DIR__ .'/../vendor/autoload.php';

$app = new Silex\application();


//code cree a letape 2.2
//code supprime à l'etape 6.4
// $app -> get('/', function(){
//       return 'Bonjour tout le monde !';
// });
//
//
// $app -> get('/hello/{name}', function($name) use($app){
//       return 'Hello ' . $app -> escape($name);
// }
// );

//$app['debug'] = true;
require __DIR__ .'/../app/config/dev.php';
require __DIR__ .'/../app/app.php';
require __DIR__ .'/../app/routes.php';

 $app -> run();

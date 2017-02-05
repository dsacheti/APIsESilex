<?php
require_once __DIR__.'/../bootstrap.php';
//require_once __DIR__ . '../src/SiApi/Controller/ProdutosController.php';

use Symfony\Component\HttpFoundation\Response;
use SiApi\Controller\ProdutosAPIController;
use SiApi\Controller\ProdutosController;

$response = new Response();

$cli = new SiApi\Entity\Clientes();

$app->get('/',function()use ($app){
    return $app['twig']->render('home.twig',array());
})->bind('home');

$app->get('/clientes',function()use($cli,$app){
    return $app->json($cli->getAll());
});

$prod = new ProdutosController();
$app->mount('/apl',$prod->connect($app));

$apiProd = new ProdutosAPIController();
$app->mount('/api',$apiProd->connect($app));

$app->run();
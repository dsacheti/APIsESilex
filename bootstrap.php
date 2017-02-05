<?php
require_once __DIR__.'/vendor/autoload.php';

use SiApi\Entity\Produto;
use SiApi\Mapper\ProdutoMapper;
use SiApi\Data\BDConn;

$app = new \Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(),array(
    'twig.path' => __DIR__.'/views/',//pasta de templates do twig
));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app['persistencia'] = function (){
    return BDConn::getBase();
};

$app['produtoService'] = function()use ($app){
    $produto = new Produto();
    $produtoMapper = new ProdutoMapper();
    $banco = $app['persistencia'];
    
    return $pService = new \SiApi\Service\ProdutoService($banco,$produto,$produtoMapper);
   
};
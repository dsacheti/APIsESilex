<?php
require_once __DIR__.'/vendor/autoload.php';

use SiApi\Entity\Produto;
use SiApi\Mapper\ProdutoMapper;

$app = new \Silex\Application();

$app['persistencia'] = function (){
    $u='homestead';
    $p = 'secret';
    try{
        return $pdo_dados = new PDO('mysql:host=localhost;dbname=apis_silex', $u, $p,array(PDO::MYSQL_ATTR_INIT_COMMAND =>"SET NAMES 'UTF8'"));
    } catch (PDOException $ex){
        return $ex;
    }
};

$app['produtoService'] = function()use ($app){
    $produto = new Produto();
    $produtoMapper = new ProdutoMapper();
    $pService = new \SiApi\Service\ProdutoService($app['persistencia'],$produto,$produtoMapper);
    return $pService;
};
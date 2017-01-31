<?php
require_once __DIR__.'/../bootstrap.php';

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

$response = new Response();

$cli = new SiApi\Entity\Clientes();

$app->get('/',function()use ($app){//usando a mágica do silex para returnar uma Responsse
    return $app['twig']->render('home.twig',array());
})->bind('home');

$app->get('/produto/cadastro',function() use ($app){
    return $app['twig']->render('cadastro.twig',array());
})->bind('cadProduto');



$app->get('/produtos',function() use ($app){
    $produtos = $app['produtoService']->fetchAll();
    return $app['twig']->render('lista.twig',array('lista'=>$produtos));
})->bind('listarProdutos');

$app->get('/clientes',function()use($cli,$app){
    return $app->json($cli->getAll());
});

$app->get('produto/alterar/{id}',function($id)use($app){
    $produto = $app['produtoService']->find($id);
    return $app['twig']->render('edicao.twig',array('produto' => $produto));
})->bind('editar');

$app->get('produto/apagar/{id}',function($id)use($app){
    $apagado = $app['produtoService']->delete($id);
    if ($apagado == true) {
        return $app->redirect($app['url_generator']->generate('apagado'));
    } else {
        return $app->abort(500,'Erro ao apagar');
    }
})->bind('apagar');

//post

$app->post('/produto/cadastro/resultado',function(Silex\Application $app,Request $request){
    $enviado = $request->request->all();

    $dados['nome'] = $enviado['nome'];
    $dados['desc'] = $enviado['desc'];
    $dados['preco'] = $enviado['preco'];

    $produtoInserido = $app['produtoService']->insert($dados);
    if($produtoInserido !=null){
        return $app->redirect($app['url_generator']->generate('sucesso'));
    }else{
        return $app->abort(500,'Erro ao cadastrar');
    }
})->bind('tratacadProduto');

$app->post('produto/altera/resultado',function(Silex\Application $app,Request $request){
    $tratar = $request->request->all();

    $prod['id'] = $tratar['id'];
    $prod['nome'] = $tratar['nome'];
    $prod['desc'] = $tratar['desc'];
    $prod['preco'] = $tratar['preco'];

    $atualizado = $app['produtoService']->update($prod);
    if ($atualizado !=null) {
        return  $app->redirect($app['url_generator']->generate('atualizado'));
    } else {
        return $app->abort(500,'Erro ao atualizar');
    }
})->bind('trataedtProduto');

//páginas de respostas

$app->get('/produto/apagado',function() use ($app){
    return $app['twig']->render('apagado.twig',array());
})->bind('apagado');

$app->get('produto/sucesso',function() use ($app){
    return $app['twig']->render('sucesso.twig',array());
})->bind('sucesso');

$app->get('produto/atualizado',function() use ($app){
    return $app['twig']->render('atualizado.twig',array());
})->bind('atualizado');

$app->run();
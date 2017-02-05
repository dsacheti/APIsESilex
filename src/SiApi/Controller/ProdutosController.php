<?php

namespace SiApi\Controller;

use SiApi\Entity\Produto;
use SiApi\Mapper\ProdutoMapper;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Silex\ControllerProviderInterface;


class ProdutosController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $produtoController = $app['controllers_factory'];

        $produtoController->get('/produto/cadastro', function () use ($app) {
            return $app['twig']->render('cadastro.twig', array());
        })->
        bind('cadProduto');

        $produtoController->get('/produtos', function () use ($app) {
            $produtos = $app['produtoService']->fetchAll();
            return $app['twig']->render('lista.twig', array('lista' => $produtos));
        })->bind('listarProdutos');

        $produtoController->get('produto/alterar/{id}', function ($id) use ($app) {
            $produto = $app['produtoService']->find($id);
            return $app['twig']->render('edicao.twig', array('produto' => $produto));
        })->bind('editar');

        $produtoController->get('produto/apagar/{id}', function ($id) use ($app) {
            $apagado = $app['produtoService']->delete($id);
            if ($apagado == true) {
                return $app->redirect($app['url_generator']->generate('apagado'));
            } else {
                return $app->abort(500, 'Erro ao apagar');
            }
        })->bind('apagar');

//post

        $produtoController->post('/produto/cadastro/resultado', function ($app, Request $request) {

            $dados['nome'] = $request->get('nome');
            $dados['desc'] = $request->get('desc');
            $dados['preco'] = $request->get('preco');

            $produtoInserido = $app['produtoService']->insert($dados);
            if ($produtoInserido != null) {
                return $app->redirect($app['url_generator']->generate('sucesso'));
            } else {
                return $app->abort(500, 'Erro ao cadastrar');
            }
        })->bind('tratacadProduto');

        $produtoController->post('produto/altera/resultado', function ($app, Request $request) {

            $prod['id'] = $request->get('id');
            $prod['nome'] = $request->get('nome');
            $prod['desc'] = $request->get('desc');
            $prod['preco'] = $request->get('preco');;

            $atualizado = $app['produtoService']->update($prod);
            if ($atualizado != null) {
                return $app->redirect($app['url_generator']->generate('atualizado'));
            } else {
                return $app->abort(500, 'Erro ao atualizar');
            }
        })->bind('trataedtProduto');

//páginas de respostas

        $produtoController->get('/produto/apagado', function () use ($app) {
            return $app['twig']->render('apagado.twig', array());
        })->bind('apagado');

        $produtoController->get('produto/sucesso', function () use ($app) {
            return $app['twig']->render('sucesso.twig', array());
        })->bind('sucesso');

        $produtoController->get('produto/atualizado', function () use ($app) {
            return $app['twig']->render('atualizado.twig', array());
        })->bind('atualizado');
        return $produtoController;
    }
}
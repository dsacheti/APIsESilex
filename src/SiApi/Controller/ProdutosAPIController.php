<?php

namespace SiApi\Controller;

use SiApi\Entity\Produto;
use SiApi\Mapper\ProdutoMapper;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Silex\ControllerProviderInterface;

class ProdutosAPIController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $apiController = $app['controllers_factory'];

        $apiController->get('/produtos', function () use ($app) {
            $produtos = $app['produtoService']->fetchAll();
            return $app->json($produtos);
        });

        $apiController->get('/produto/{id}', function ($id) use ($app) {
            if ($this->validarNum($id)) {
                $produto['id'] = $id;
            } else {
                return $app->json(['Erro' => 'Verifique o Id fornecido']);
            }
            if ($produto != null) {
                return $app->json($produto);
            } else {
                return $app->json(['Erro' => 'Produto não encontrado']);
            }
        });

        $apiController->post('/produto/cadastrar', function (Application $app, Request $request) {

            if ($this->validarString($request->get('nome'))) {
                $dados['nome'] = $request->get('nome');
            } else {
                return $app->json(['Erro' => 'Verifique o nome do produto']);
            }

            if ($this->validarString($request->get('desc'))) {
                $dados['desc'] = $request->get('desc');
            } else {
                return $app->json(['Erro' => 'Verifique a descrição do produto']);
            }

            if ($this->validarNum($request->get('preco'))) {
                if( strpos($request->get('preco'),'.') !== false) {
                    $dados['preco'] = 'R$ ' . str_replace('.', ',', $request->get('preco'));
                }
            } else if(strpos($request->get('preco'),',') !== false) {
                return $app->json(['Erro' => 'Use ponto para separar os centavos']);
            } else {
                return $app->json(['Erro' => 'Verifique o valor do produto. ATENÇÃO, este campo aceita somente números']);
            }

            $produtoInserido = $app['produtoService']->insert($dados);
            if ($produtoInserido != null) {
                return $app->json(['Sucesso' => 'Produtos cadastrado com sucesso']);
            } else {
                return $app->json(['Erro' => 'Erro ao cadastrar o produto']);
            }
        });

        $apiController->put('/produto/alterar/{id}', function (Request $request, $id) use ($app) {
            if ($this->validarNum($id)) {
                $prod['id'] = $id;
            } else {
                return $app->json(['Erro' => 'Verifique o Id fornecido']);
            }

            if ($this->validarString($request->get('nome'))) {
                $prod['nome'] = $request->get('nome');
            } else {
                return $app->json(['Erro' => 'Verifique o nome do produto']);
            }

            if ($this->validarString($request->get('desc'))) {
                $prod['desc'] = $request->get('desc');
            } else {
                return $app->json(['Erro' => 'Verifique a descrição do produto']);
            }

            if ($this->validarNum($request->get('preco'))) {
                if( strpos($request->get('preco'),'.') !== false) {
                    $prod['preco'] = 'R$ ' . str_replace('.', ',', $request->get('preco'));
                }
            } else if(strpos($request->get('preco'),',') !== false) {
                return $app->json(['Erro' => 'Use ponto para separar os centavos']);
            } else {
                return $app->json(['Erro' => 'Verifique o valor do produto. ATENÇÃO, este campo aceita somente números']);
            }

            $atualizado = $app['produtoService']->update($prod);
            if ($atualizado != null) {
                return $app->json(['Sucesso' => 'Produto atualizado com sucesso']);
            } else {
                return $app->json(['Erro' => 'Não foi possível atualizar os dados do produto']);
            }
        });

        $apiController->delete('/produto/apagar/{id}', function ($id) use ($app) {

            if($this->validarNum($id)) {
                $apagado = $app['produtoService']->delete($id);
                if ($apagado == true) {
                    return $app->json(['Sucesso' => 'Produto apagado com sucesso']);
                } else {
                    return $app->json(['Erro' => 'Não foi possível apagar']);
                }
            }else {
                return $app->json(['Erro' =>'Verifique o Id digitado']);
            }
        });
        return $apiController;
    }

    private function validarString($entrada)
    {
        $entrada = trim($entrada);
        if (!strlen($entrada) > 0 ) {
            return false;
        } else {
            return true;
        }
    }

    private function validarNum($entrada)
    {
        if (!is_numeric($entrada) or ($entrada <= 0)) {
            return false;
        } else {
            return true;
        }
    }

}


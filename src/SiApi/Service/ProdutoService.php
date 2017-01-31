<?php


namespace SiApi\Service;

use SiApi\Entity\Produto;
use SiApi\Mapper\ProdutoMapper;
/**
 * Description of ProdutoService
 *
 * @author DELL
 */
class ProdutoService 
{
    /**
     *
     * @var \PDO
     */
    private $bd;
    
    /**
     *
     * @var Produto
     */
    private $produto;
    
    /**
     *
     * @var ProdutoMapper
     */
    private $produtoMapper;
    
    public function __construct(\PDO $bd,Produto $prod, ProdutoMapper $produtoMapper) 
    {
        $this->bd = $bd;
        $this->produto = $prod;
        $this->produtoMapper = $produtoMapper;
    }
    
    public function insert(array $dados)
    {
        $produto = $this->produto;
        $produto->setNome($dados['nome']);
        $produto->setDescricao($dados['desc']);
        $produto->setValor($dados['preco']);
        
        $sim = $this->produtoMapper->table($this->bd);
        if ($sim) {
            return $this->produtoMapper->insert($produto, $this->bd);
        }
    }
    
    public function fetchAll(){
        $lista = $this->produtoMapper->fetchAll($this->bd);
        $prodLista = array();
        $i = 0;
        foreach ($lista as $item) {
            $this->produto->setId($item['id']);
            $this->produto->setNome($item['nome']);
            $this->produto->setDescricao($item['desc']);
            $this->produto->setValor($item['preco']);
            $prodLista[$i] = $this->produto->toArray();
            $i++;
        }
        return $prodLista;
    }
    
    public function find(int $id)
    {
        $dados = $this->produtoMapper->find($this->bd, $id);
        $p = array();
        $p['id'] = $dados['id'];
        $p['nome'] = $dados['nome'];
        $p['desc'] = $dados['desc'];
        $p['preco'] = $dados['preco'];
        return $p;
    }
    
    public function update(array $dados)
    {
		$produto = $this->produto;
        $produto->setId($dados['id']);
		$produto->setNome($dados['nome']);
		$produto->setDescricao($dados['desc']);
		$produto->setValor($dados['preco']);
		
        return $this->produtoMapper->update($this->bd, $produto);
    }
    
    public function delete(int $id)
    {
        $id = (int)$id;
        return $this->produtoMapper->delete($this->bd, $id);
    }
}

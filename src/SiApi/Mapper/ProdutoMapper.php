<?php

namespace SiApi\Mapper;

use SiApi\Entity\Produto;


class ProdutoMapper
{
    
    public function insert(Produto $produto, \PDO $bd)
    {
        $nome = $produto->getNome();
        $desc = $produto->getDescricao();
        $preco = $produto->getValor();
        try {
            $stmt = $bd->prepare("INSERT INTO produtos ('nome','desc','preco') VALUES (:nome,:desc,:preco)");
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':desc', $desc);
            $stmt->bindParam(':preco', $preco);
            $stmt->execute();
            return $produto;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    
    public function fetchAll( \PDO $bd)
	{
        try {
            $sql = $bd->prepare("SELECT * FROM produtos");
            $sql->execute();
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $retorno;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    
    public function find(\PDO $bd, $id)
    {
        try {
            $stmt = $bd->prepare("SELECT * FROM produtos WHERE id= :id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $retorno = $stmt->fetch();
            return $retorno;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    
    public function update(\PDO $bd, Produto $produto)
    {
        try {
            $save = $bd->prepare("UPDATE produtos SET nome = :nome, desc = :desc, preco = :preco");
            $save->bindParam(':nome', $produto->getNome());
            $save->bindParam(':desc', $produto->getDescricao());
            $save->bindParam(':preco', $produto->getValor());
            $save->execute();
            return $produto;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    
    public function delete(\PDO $bd,int $id)
    {
        try {
            $apaga = $bd->prepare("DELETE FROM produtos WHERE id = :id");
            $apaga->bindParam(':id', $id);
            return 'Produto apagado';
        } catch (PDOException $ex) {
            return $ex;
        }
    }
}
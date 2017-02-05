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
            $stmt = $bd->prepare("INSERT INTO `produtos` (`nome`,`desc`,`preco`) VALUES (:nome,:desc,:preco)");
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':desc', $desc);
            $stmt->bindParam(':preco', $preco);
            $stmt->execute();
            $emArray = [
                'nome'=> $nome,
                'descricao' => $desc,
                'valor' => $preco
            ];
            return $emArray;
        } catch (\PDOException $ex) {
            return $ex;
        }
    }
    
    public function fetchAll( \PDO $bd)
	{
        try {
            $sql = $bd->prepare("SELECT * FROM `produtos`");
            $sql->execute();
            $retorno = $sql->fetchAll(\PDO::FETCH_ASSOC);
            return $retorno;
        } catch (\PDOException $ex) {
            return $ex;
        }
    }
    
    public function find(\PDO $bd, $id)
    {
        try {
            $stmt = $bd->prepare("SELECT * FROM `produtos` WHERE `id`= :id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $retorno = $stmt->fetch();
            return $retorno;
        } catch (\PDOException $ex) {
            return $ex;
        }
    }

    public function update(\PDO $bd, Produto $produto)
    {
        try {
            $save = $bd->prepare("UPDATE `produtos` SET `nome` = :nome, `desc` = :desc, `preco` = :preco WHERE `id` = :id");
            $save->bindParam(':nome', $produto->getNome());
            $save->bindParam(':desc', $produto->getDescricao());
            $save->bindParam(':preco', $produto->getValor());
            $save->bindParam(':id',$produto->getId());
            $save->execute();
            return $produto;
        } catch (\PDOException $ex) {
            return $ex;
        }
    }
    
    public function delete(\PDO $bd,int $id)
    {
        try {
            $apaga = $bd->prepare("DELETE FROM `produtos` WHERE `id` = :id");
            $apaga->bindParam(':id', $id);
            $apaga->execute();
            return true;
        } catch (\PDOException $ex) {
            return $ex;
        }
    }
    
    public function table(\PDO $bd){
        try {
            $stmt = $bd->prepare('CREATE TABLE IF NOT EXISTS `produtos` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
            `desc` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
            `preco` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=343 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
            return $stmt->execute();
        } catch (\PDOException $ex) {
            return $ex;
        }
    }
}
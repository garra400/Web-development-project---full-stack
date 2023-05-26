<?php
//DAO = Data Access Object

class ProdutoDAO {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obter todas as pessoas da tabela
     */
    public function getAll() {
        $stmt = $this->pdo->prepare("SELECT * FROM tb_produto");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Inserir uma pessoa no banco de dados
     */
    public function insert($produto) {
        $stmt = $this->pdo->prepare("INSERT INTO tb_produto 
            (nome, descricao, preco, quantidade) 
            VALUES (:nome, :descricao, :preco, :quantidade)");
        
        $stmt->bindValue("nome", $produto->nome);
        $stmt->bindValue("descricao", $produto->descricao);
        $stmt->bindValue("preco", $produto->preco);
        $stmt->bindValue("quantidade", $produto->quantidade);


        $stmt->execute();
        $produto = clone $produto;
        $produto->id = $this->pdo->lastInsertId();
        return $produto;
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tb_produto 
        WHERE id=:id");
        
        $stmt->bindValue("id", $id);

        $stmt->execute();
        
        // Retorna a qdt de linhas afetadas
        return $stmt->rowCount();
    }

    public function update($id, $produto) {
        $stmt = $this->pdo->prepare("UPDATE tb_produto SET
                nome = :nome, descricao = :descricao,
                preco = :preco, quantidade = :quantidade
                WHERE id = :id");
        
        $data = [
            "id" => $id,
            "nome" => $produto->nome,
            "descricao" => $produto->descricao,
            "preco" => $produto->preco,
            "quantidade" => $produto->quantidade
        ];

        return $stmt->execute($data);
    }
}

?>
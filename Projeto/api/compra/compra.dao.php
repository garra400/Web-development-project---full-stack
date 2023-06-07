<?php
//DAO = Data Access Object

class CompraDAO {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obter todas as compras da tabela
     */
    public function getAll() {
        $stmt = $this->pdo->prepare("SELECT * FROM tb_compra");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Inserir uma compra no banco de dados
     */
    public function insert($compra) {
        $stmt = $this->pdo->prepare("INSERT INTO tb_compra
            (id_usuario, data_compra) 
            VALUES (:id_usuario, :data_compra)");
        
        $stmt->bindValue("id_usuario", $compra->id_usuario);
        $stmt->bindValue("data_compra", $compra->data_compra);

        $stmt->execute();
        $compra = clone $compra;
        $compra->id = $this->pdo->lastInsertId();

        foreach ($compra->produtos as $produto) {
            $stmt = $this->pdo->prepare("INSERT INTO tb_compra_produto
            (id_compra, id_produto, preco_produto, quantidade) 
            VALUES (:id_compra, :id_produto, :preco_produto, :quantidade)");
        
            $stmt->bindValue("id_compra", $compra->id);
            $stmt->bindValue("id_produto", $produto->id);
            $stmt->bindValue("preco_produto", $produto->preco);
            $stmt->bindValue("quantidade", $produto->quantidade);

            $stmt->execute();
        }
        return $compra;
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tb_compra_produto
        WHERE id_compra=:id_compra");
        
        $stmt->bindValue("id_compra", $id);

        $stmt->execute();
        
        $stmt = $this->pdo->prepare("DELETE FROM tb_compra
        WHERE id=:id");
        
        $stmt->bindValue("id", $id);

        $stmt->execute();
        
        // Retorna a qdt de linhas afetadas
        return $stmt->rowCount();
    }

    public function update($id, $compra) {
        $stmt = $this->pdo->prepare("UPDATE tb_compra SET
                id_usuario = :id_usuario, data_compra = :data_compra
                WHERE id = :id");
        
        $data = [
            "id" => $id,
            "id_usuario" => $compra->id_usuario,
            "data_compra" => $compra->data_compra
        ];
        print_r($data);
        return $stmt->execute($data);
    }
}

?>
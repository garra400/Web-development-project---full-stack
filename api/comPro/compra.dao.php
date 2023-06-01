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
            (id_usuario) 
            VALUES (:id_usuario)");
        
        $stmt->bindValue("id_usuario", $compra->id_usuario);

        $stmt->execute();
        $compra = clone $compra;
        $compra->id = $this->pdo->lastInsertId();
        return $compra;
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tb_compra
        WHERE id=:id");
        
        $stmt->bindValue("id", $id);

        $stmt->execute();
        
        // Retorna a qdt de linhas afetadas
        return $stmt->rowCount();
    }

    public function update($id, $compra) {
        $stmt = $this->pdo->prepare("UPDATE tb_compra SET
                id_usuario = :id_usuario
                WHERE id = :id");
        
        $data = [
            "id" => $id,
            "id_usuario" => $compra->id_usuario,
        ];

        return $stmt->execute($data);
    }
}

?>
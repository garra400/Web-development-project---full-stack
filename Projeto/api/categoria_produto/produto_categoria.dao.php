<?php
//DAO = Data Access Object

class Produto_categoriaDAO {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obter todas as categorias da tabela
     */
    public function getAll() {
        $stmt = $this->pdo->prepare("SELECT * FROM tb_produto_categoria");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Inserir uma categoria ao produto
     */
    public function insert($produto_categoria) {
        $stmt = $this->pdo->prepare("INSERT INTO tb_produto_categoria
            (nome) 
            VALUES (:nome)");
        
        $stmt->bindValue("nome", $produto_categoria->nome);

        $stmt->execute();
        $produto_categoria = clone $produto_categoria;
        $produto_categoria->id = $this->pdo->lastInsertId();
        return $produto_categoria;
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tb_produto_categoria 
        WHERE id=:id");
        
        $stmt->bindValue("id", $id);

        $stmt->execute();
        
        // Retorna a qdt de linhas afetadas
        return $stmt->rowCount();
    }

    public function update($id, $produto_categoria) {
        $stmt = $this->pdo->prepare("UPDATE tb_produto_categoria SET
                nome = :nome
                WHERE id = :id");
        
        $data = [
            "id" => $id,
            "nome" => $produto_categoria->nome,
        ];

        return $stmt->execute($data);
    }
}

?>
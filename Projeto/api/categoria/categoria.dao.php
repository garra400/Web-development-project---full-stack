<?php
// DAO = Data Access Object

class CategoriaDAO {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obter todas as categorias da tabela
     * Permissões: Público
     */
    public function getAll() {
        $stmt = $this->pdo->prepare("SELECT * FROM tb_categoria");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Inserir uma categoria no banco de dados
     * Permissões: Admin
     */
    public function insert($categoria) {
        $stmt = $this->pdo->prepare("INSERT INTO tb_categoria 
            (nome) 
            VALUES (:nome)");
        
        $stmt->bindValue("nome", $categoria->nome);

        $stmt->execute();
        $categoria = clone $categoria;
        $categoria->id = $this->pdo->lastInsertId();
        return $categoria;
    }

    /**
     * Deletar uma categoria do banco de dados
     * Permissões: Admin
     */
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tb_categoria 
        WHERE id=:id");
        
        $stmt->bindValue("id", $id);

        $stmt->execute();
        
        // Retorna a quantidade de linhas afetadas
        return $stmt->rowCount();
    }

    /**
     * Atualizar uma categoria no banco de dados
     * Permissões: Admin
     */
    public function update($id, $categoria) {
        $stmt = $this->pdo->prepare("UPDATE tb_categoria SET
                nome = :nome
                WHERE id = :id");
        
        $data = [
            "id" => $id,
            "nome" => $categoria->nome,
        ];

        return $stmt->execute($data);
    }
}

?>

<?php
// DAO = Data Access Object

class ProdutoDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obter todos os produtos da tabela
     * Permissões: Público
     */
    public function getAll() {
        $stmt = $this->pdo->prepare("SELECT * FROM tb_produto");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Obter um produto pelo ID
     * Permissões: Público
     */
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM tb_produto WHERE id = :id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Obter produtos por categoria
     * Permissões: Público
     */
    public function getByCategory($category) {
        $stmt = $this->pdo->prepare("SELECT * FROM tb_produto WHERE categoria = :category");
        $stmt->bindValue(":category", $category);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Inserir um produto no banco de dados
     * Permissões: Admin
     */
    public function insert($produto) {
        // Verificar se o usuário logado é admin

        $stmt = $this->pdo->prepare("INSERT INTO tb_produto 
            (nome, descricao, preco, quantidade, id_categoria) 
            VALUES (:nome, :descricao, :preco, :quantidade, :id_categoria)");

        $stmt->bindValue(":nome", $produto->nome);
        $stmt->bindValue(":descricao", $produto->descricao);
        $stmt->bindValue(":preco", $produto->preco);
        $stmt->bindValue(":quantidade", $produto->quantidade);
        $stmt->bindValue(":id_categoria", $produto->id_categoria);

        $stmt->execute();
        
        $produto->id = $this->pdo->lastInsertId();

        return $produto;
    }

    /**
     * Atualizar um produto no banco de dados
     * Permissões: Admin
     */
    public function update($id, $produto) {
        // Verificar se o usuário logado é admin

        $stmt = $this->pdo->prepare("UPDATE tb_produto SET
            nome = :nome, descricao = :descricao,
            preco = :preco, quantidade = :quantidade, id_categoria = :id_categoria
            WHERE id = :id");

        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":nome", $produto->nome);
        $stmt->bindValue(":descricao", $produto->descricao);
        $stmt->bindValue(":preco", $produto->preco);
        $stmt->bindValue(":quantidade", $produto->quantidade);
        $stmt->bindValue(":id_categoria", $produto->id_categoria);

        return $stmt->execute();
    }

    /**
     * Deletar um produto do banco de dados
     * Permissões: Admin
     */
    public function delete($id) {
        // Verificar se o usuário logado é admin

        $stmt = $this->pdo->prepare("DELETE FROM tb_produto WHERE id = :id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        // Retorna a quantidade de linhas afetadas
        return $stmt->rowCount();
    }
}
?>

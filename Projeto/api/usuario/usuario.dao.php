<?php
//DAO = Data Access Object

class UsuarioDAO {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obter todas as pessoas da tabela
     */
    public function getAll() {
        $stmt = $this->pdo->prepare("SELECT * FROM tb_usuario");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Inserir uma pessoa no banco de dados
     */
    public function insert($usuario) {
        $stmt = $this->pdo->prepare("INSERT INTO tb_usuario 
            (nome, email, senha, nascimento, administrador) 
            VALUES (:nome, :email, :senha, :nasc, :adm)");
        
        $stmt->bindValue("nome", $usuario->nome);
        $stmt->bindValue("email", $usuario->email);
        $stmt->bindValue("senha", $usuario->senha);
        $stmt->bindValue("nasc", $usuario->nascimento);
        $stmt->bindValue("adm", $usuario->administrador);

        $stmt->execute();
        $usuario = clone $usuario;
        $usuario->id = $this->pdo->lastInsertId();
        return $usuario;
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tb_usuario 
        WHERE id=:id");
        
        $stmt->bindValue("id", $id);

        $stmt->execute();
        
        // Retorna a qdt de linhas afetadas
        return $stmt->rowCount();
    }

    public function update($id, $usuario) {
        $stmt = $this->pdo->prepare("UPDATE tb_usuario SET
                nome = :nome, email = :email,
                nascimento = :nascimento
                WHERE id = :id");
        
        $data = [
            "id" => $id,
            "nome" => $usuario->nome,
            "nascimento" => $usuario->nascimento,
            "email" => $usuario->email
        ];

        return $stmt->execute($data);
    }
}

?>
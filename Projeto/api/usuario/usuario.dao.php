<?php
// DAO = Data Access Object

class UsuarioDAO {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obter todos os usuários da tabela
     * Permissões: Admin
     */
    public function getAll() {
        // Verificar se o usuário logado é admin
        if ($loggedUserName !== 'admin') {
            throw new Exception('Apenas administradores podem obter todos os usuários.');
        }

        $stmt = $this->pdo->prepare("SELECT * FROM tb_usuario");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Obter um usuário pelo ID
     * Permissões: Admin
     */
    public function getById($id) {
        // Verificar se o usuário logado é admin
        if ($loggedUserName !== 'admin') {
            throw new Exception('Apenas administradores podem obter um usuário pelo ID.');
        }

        $stmt = $this->pdo->prepare("SELECT * FROM tb_usuario WHERE id = :id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Inserir um usuário no banco de dados
     * Permissões: Público
     */
    public function insert($usuario) {
        // Verificar se o usuário logado é admin
        if ($loggedUserName !== 'admin') {
            throw new Exception('Apenas administradores podem criar um usuário.');
        }

        $stmt = $this->pdo->prepare("INSERT INTO tb_usuario 
            (nome, email, senha, nascimento, administrador) 
            VALUES (:nome, :email, :senha, :nasc, :adm)");
        
        $stmt->bindValue(":nome", @$usuario->nome);
        $stmt->bindValue(":email", @$usuario->email);
        $stmt->bindValue(":senha", @$usuario->senha);
        $stmt->bindValue(":nasc", @$usuario->nascimento);
        $stmt->bindValue(":adm", @$usuario->administrador);

        $stmt->execute();
        $usuario = clone $usuario;
        $usuario->id = $this->pdo->lastInsertId();

        return $usuario;
    }

    /**
     * Atualizar um usuário no banco de dados
     * Permissões: Usuário logado ou admin
     */
    public function update($id, $usuario) {
        // Verificar se o usuário logado é o próprio usuário ou admin
        if ($loggedUserName !== $usuario->nome && $loggedUserName !== 'admin') {
            throw new Exception('Apenas o próprio usuário ou administradores podem atualizar um usuário.');
        }

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

    /**
     * Deletar um usuário do banco de dados
     * Permissões: Usuário logado ou admin
     */
    public function delete($id) {
        // Verificar se o usuário logado é o próprio usuário ou admin
        if ($loggedUserName !== 'admin' && $loggedUserName !== $this->getUserNameById($id)) {
            throw new Exception('Apenas o próprio usuário ou administradores podem deletar um usuário.');
        }

        $stmt = $this->pdo->prepare("DELETE FROM tb_usuario WHERE id = :id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        // Retorna a quantidade de linhas afetadas
        return $stmt->rowCount();
    }

    /**
     * Obter o nome de um usuário pelo ID
     * Permissões: Admin
     */
    private function getUserNameById($id) {
        // Verificar se o usuário logado é admin
        if ($loggedUserName !== 'admin') {
            throw new Exception('Apenas administradores podem obter o nome de um usuário pelo ID.');
        }

        $stmt = $this->pdo->prepare("SELECT nome FROM tb_usuario WHERE id = :id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        return $stmt->fetchColumn();
    }
}
?>

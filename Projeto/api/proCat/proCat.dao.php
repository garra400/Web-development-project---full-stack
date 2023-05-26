<?php
//DAO = Data Access Object
//proCat = Produto_Categoria

class ProCatDAO {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obter todas as pessoas da tabela
     */
    public function getAll() {
        $stmt = $this->pdo->prepare("SELECT * FROM tb_produto_categoria");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Inserir uma pessoa no banco de dados
     */
    public function insert($proCat) {
        $stmt = $this->pdo->prepare("INSERT INTO tb_produto_categoria 
            (id_produto, id_categoria) 
            VALUES (:id_produto, :id_categoria)");
        
        $stmt->bindValue("id_produto", $proCat->id_produto);
        $stmt->bindValue("id_categoria", $proCat->id_categoria);

        $stmt->execute();
        /*$proCat = clone $proCat;
        $proCat->id = $this->pdo->lastInsertId();*/
        return $proCat;
    }
}

?>
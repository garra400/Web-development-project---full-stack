<?php
    // Abrir a conexão
    require_once('../db/connection.inc.php');
    require_once('produto_categoria.dao.php');

    // Rec

    // Instanciar o DAO
    $produto_categoriaDAO = new Produto_categoriaDAO($pdo);

    // Receber os dados do cliente
    $json = file_get_contents('php://input');

    // Criar um objeto a partir do JSON
    $categoria = json_decode($json);

    // Conteúdo de resposta para o cliente
    $responseBody = "";

    // Inserir o usuário no banco de dados
    $categoria = $produto_categoriaDAO->insert($produto_categoria);
    $responseBody = json_encode($produto_categoria); // Transf. em JSON

    // Gerar a resposta para o cliente
    header("Content-type: application/json");
    print_r($responseBody);

?>
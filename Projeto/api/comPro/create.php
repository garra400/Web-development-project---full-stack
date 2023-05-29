<?php
    // Abrir a conexão
    require_once('../db/connection.inc.php');
    require_once('compra.dao.php');

    // Instanciar o DAO
    $compraDAO = new CompraDAO($pdo);

    // Receber os dados do cliente
    $json = file_get_contents('php://input');

    // Criar um objeto a partir do JSON
    $compra = json_decode($json);

    // Conteúdo de resposta para o cliente
    $responseBody = "";

    // Inserir o usuário no banco de dados
    $compra = $compraDAO->insert($compra);
    $responseBody = json_encode($compra); // Transf. em JSON

    // Gerar a resposta para o cliente
    header("Content-type: application/json");
    print_r($responseBody);

?>
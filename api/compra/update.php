<?php
    // Abrir a conexão
    require_once('../db/connection.inc.php');
    require_once('compra.dao.php');

    // Instanciar o DAO
    $compraDAO = new CompraDAO($pdo);

    // Conteúdo de resposta para o cliente
    $responseBody = "";

    // Obtendo o parâmetro id vindo pela URL da requisição
    $id = $_REQUEST["id"];

    if(!$id) {
        $responseBody = '{ "message": "compra não informada"}';
        http_response_code(404);
    } else {
        // Receber os dados do cliente
        $json = file_get_contents('php://input');

        // Criar um objeto a partir do JSON
        $compra = json_decode($json);

        // Inserir a compra no banco de dados
        $compra = $compraDAO->update($id, $compra);
        $responseBody = json_encode($compra); // Transf. em JSON
    }


    // Gerar a resposta para o cliente
    header("Content-type: application/json");
    print_r($responseBody);

?>
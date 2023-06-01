<?php
    // Abrir a conexão
    require_once('../db/connection.inc.php');
    require_once('produto.dao.php');

    // Instanciar o DAO
    $produtoDAO = new ProdutoDAO($pdo);

    // Conteúdo de resposta para o cliente
    $responseBody = "";

    // Obtendo o parâmetro id vindo pela URL da requisição
    $id = $_REQUEST["id"];

    if(!$id) {
        $responseBody = '{ "message": "Produto não informado"}';
        http_response_code(404);
    } else {
        // Receber os dados do cliente
        $json = file_get_contents('php://input');

        // Criar um objeto a partir do JSON
        $produto = json_decode($json);

        // Inserir o produto no banco de dados
        $produto = $produtoDAO->update($id, $produto);
        $responseBody = json_encode($produto); // Transf. em JSON
    }


    // Gerar a resposta para o cliente
    header("Content-type: application/json");
    print_r($responseBody);

?>
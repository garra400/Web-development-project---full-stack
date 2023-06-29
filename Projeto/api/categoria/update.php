<?php
    // Abrir a conexão
    require_once('../db/connection.inc.php');
    require_once('categoria.dao.php');

    // Instanciar o DAO
    $categoriaDAO = new CategoriaDAO($pdo);

    // Conteúdo de resposta para o cliente
    $responseBody = "";

    // Obtendo o parâmetro id vindo pela URL da requisição
    $id = $_REQUEST["id"];

    if(!$id) {
        $responseBody = '{ "message": "Categoria não informada"}';
        http_response_code(404);
    } else {
        // Receber os dados do cliente
        $json = file_get_contents('php://input');

        // Criar um objeto a partir do JSON
        $categoria = json_decode($json);

        // Inserir a categoria no banco de dados
        $categoria = $categoriaDAO->update($id, $categoria);
        $responseBody = json_encode($categoria); // Transf. em JSON
    }


    // Gerar a resposta para o cliente
    header("Content-type: application/json");
    print_r($responseBody);

?>
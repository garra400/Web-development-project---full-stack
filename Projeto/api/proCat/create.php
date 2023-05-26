<?php
    // Abrir a conexão
    require_once('../db/connection.inc.php');
    require_once('proCat.dao.php');

    // Instanciar o DAO
    $proCatDAO = new ProCatDAO($pdo);

    // Receber os dados do cliente
    $json = file_get_contents('php://input');

    // Criar um objeto a partir do JSON
    $proCat = json_decode($json);

    // Conteúdo de resposta para o cliente
    $responseBody = "";

    // Inserir o usuário no banco de dados
    $proCat = $proCatDAO->insert($proCat);
    $responseBody = json_encode($proCat); // Transf. em JSON

    // Gerar a resposta para o cliente
    header("Content-type: application/json");
    print_r($responseBody);
?>
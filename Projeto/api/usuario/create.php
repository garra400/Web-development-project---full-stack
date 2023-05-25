<?php
    // Abrir a conexão
    require_once('../db/connection.inc.php');
    require_once('usuario.dao.php');

    // Instanciar o DAO
    $usuarioDAO = new UsuarioDAO($pdo);

    // Receber os dados do cliente
    $json = file_get_contents('php://input');

    // Criar um objeto a partir do JSON
    $usuario = json_decode($json);

    // Conteúdo de resposta para o cliente
    $responseBody = "";

    // Inserir o usuário no banco de dados
    $usuario = $usuarioDAO->insert($usuario);
    $responseBody = json_encode($usuario); // Transf. em JSON

    // Gerar a resposta para o cliente
    header("Content-type: application/json");
    print_r($responseBody);




?>
<?php
    /**
     * Método para entregar uma lista de usuários
     * para o cliente.
     * 
     * Formato de entrega: JSON
     */
    require_once('../db/connection.inc.php');
    require_once('usuario.dao.php');

    $usuarioDAO = new UsuarioDAO($pdo);

    // Buscar as usuários no DB
    $usuarios = $usuarioDAO->getAll();

    $responseBody = json_encode($usuarios);

    header('Content-type: application/json');
    print_r($responseBody);
?>
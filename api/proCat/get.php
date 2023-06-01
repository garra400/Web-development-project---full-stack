<?php
    /**
     * Método para entregar uma lista de produtos_categoria
     * para o cliente.
     * 
     * Formato de entrega: JSON
     */
    require_once('../db/connection.inc.php');
    require_once('proCat.dao.php');

    $proCatDAO = new ProCatDAO($pdo);

    // Buscar as produtos no DB
    $proCats = $proCatDAO->getAll();

    $responseBody = json_encode($proCats);

    header('Content-type: application/json');
    print_r($responseBody);
?>
<?php
    /**
     * Método para entregar uma lista de compras
     * para o cliente.
     * 
     * Formato de entrega: JSON
     */
    require_once('../db/connection.inc.php');
    require_once('compra.dao.php');

    $compraDAO = new CompraDAO($pdo);

    // Buscar as compras no DB
    $compras = $compraDAO->getAll();

    $responseBody = json_encode($compras);

    header('Content-type: application/json');
    print_r($responseBody);
?>
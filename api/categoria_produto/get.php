<?php
    /**
     * Método para entregar uma lista de categorias
     * para o cliente.
     * 
     * Formato de entrega: JSON
     */
    require_once('../db/connection.inc.php');
    require_once('produto_categoria.dao.php');

    $produto_categoriaDAO = new Produto_categoriaDAO($pdo);

    // Buscar as categorias no DB
    $produto_categoria = $produto_categoriaDAO->getAll();

    $responseBody = json_encode($produto_categoria);

    header('Content-type: application/json');
    print_r($responseBody);
?>
<?php
    // Recursp para criar um produto
    // Restrito a usuários autenticados

    //Verificar se foi passado um token
    require_once("validate-jwt.inc.php");


    print_r("Produto criado com sucesso!");

?>
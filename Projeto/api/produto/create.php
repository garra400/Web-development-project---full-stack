<?php
    // Abrir a conexão
    require_once('../db/connection.inc.php');
    require_once('produto.dao.php');
    // Instanciar o DAO
    $produtoDAO = new ProdutoDAO($pdo);

    // Receber os dados do cliente
    $json = file_get_contents('php://input');

    // Criar um objeto a partir do JSON
    $produto = json_decode($json);

    // Conteúdo de resposta para o cliente
    $responseBody = "";
    
    try{
        $decodeToken = JwtUtil::decode($jwt, JWT_SECRET_KEY);
        $admin = isset($decodeToken['administrador']) && ($decodeToken['administrador'] = 1);
        if ($admin){
            try{
            $produto = $produtoDAO->insert($produto);
            $responseBody = json_encode($produto); // Transf. em JSON
            }
            catch(Exception $e){
                http_response_code(400);
            }
            // Gerar a resposta para o cliente
        }
        else{
            http_response_code(400);
        }

    } catch(Exception $e){
        http_response_code(400);
    }
    header("Content-type: application/json");
        print_r($responseBody);

?>
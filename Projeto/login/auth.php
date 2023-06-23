<?php   

    require_once("lib/jwtutil.inc.php");
    require_once("config.php");

    // Receber o JSON enviado pelo cliente
    // Obter o conteúdo do corpo de requisição
    $json = file_get_contents('php://input');

    // Transforma o JSON em um Objeto PHP
    $credentials = json_decode($json);

    $responseBody = ''; // Variável para armazenar a respo

    if($credentials->username == "admin" &&
        $credentials->password == "1234") {

        $payload = [
            "id" => 1,
            "username" => $credentials->username,
            "role" => "admin"
        ]; 

        //Gerar o token (codificar), usando a classe disponível no sistema
        $token = JwtUtil::encode($payload, JWT_SECRET_KEY);

        $responseBody = '{ "token": "'.$token.'" }';
    }
    else{
        http_response_code(401); //Unauthorized
        $responseBody = '{ "message": "Credencial inválida"}';
    }

    print_r($responseBody);
?>
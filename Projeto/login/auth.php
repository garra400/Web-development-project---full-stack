<?php   
    $servername = 'localhost';
    $port = 3306;
    $username = 'root';
    $password = '';
    $dbname = 'db_projeto';

    $pdo = new PDO(
        "mysql:host=$servername;port=$port;dbname=$dbname", 
        $username, 
        $password
    );
    require_once("lib/jwtutil.inc.php");
    require_once("config.php");

    // Receber o JSON enviado pelo cliente
    // Obter o conteúdo do corpo de requisição
    $json = file_get_contents('php://input');

    // Transforma o JSON em um Objeto PHP
    $credentials = json_decode($json);

    $responseBody = ''; // Variável para armazenar a respo

    // Consulta para obter as informações do usuário
    $query = "SELECT * FROM tb_usuario WHERE nome = :username AND senha = :password";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $credentials->username);
    $stmt->bindParam(':password', $credentials->password);
    $stmt->execute();

    // Verificar se os dados do usuário correspondem às informações fornecidas
    if($stmt->rowCount() > 0) {
        // Dados do usuário encontrados no banco de dados
        // Realize as ações necessárias, como gerar um token, retornar uma resposta bem-sucedida etc.
        $payload = [
            "id" => 1,
            "username" => $credentials->username,
            "role" => "admin"
        ]; 

        // Gerar o token (codificar), usando a classe disponível no sistema
        $token = JwtUtil::encode($payload, JWT_SECRET_KEY);

        $responseBody = '{ "token": "'.$token.'" }';
    } else {
        // Dados do usuário não encontrados ou inválidos
        // Retorne uma resposta de credencial inválida
        http_response_code(401); //Unauthorized
        $responseBody = '{ "message": "Credencial inválida"}';
    }

    echo $responseBody;
    print_r($responseBody);
?>

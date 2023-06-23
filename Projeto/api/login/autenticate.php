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
$json = file_get_contents('php://input');

// Transformar o JSON em um objeto PHP
$credentials = json_decode($json);

$responseBody = ''; // Variável para armazenar a resposta

if ($credentials && isset($credentials->username) && isset($credentials->password)) {
    // Consulta para obter as informações do usuário
    $query = "SELECT * FROM tb_usuario WHERE nome = :username AND senha = :password";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $credentials->username);
    $stmt->bindParam(':password', $credentials->password);
    $stmt->execute();

    // Verificar se os dados do usuário correspondem às informações fornecidas
    if ($stmt->rowCount() > 0) {
        // Dados do usuário encontrados no banco de dados
        // Realizar as ações necessárias, como gerar um token, retornar uma resposta bem-sucedida, etc.
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $payload = [
            "id" => $user['id'],
            "username" => $user['nome'],
            "administrador" => $user['administrador'] == 1 ? 1 : null
        ];

        // Gerar o token (codificar), usando a classe disponível no sistema
        $token = JwtUtil::encode($payload, JWT_SECRET_KEY);

        $responseBody = json_encode(['token' => $token]);
        http_response_code(200); // OK
    } else {
        // Dados do usuário não encontrados ou inválidos
        // Retornar uma resposta de credencial inválida
        $responseBody = json_encode(['message' => 'Credencial inválida']);
        http_response_code(401); // Unauthorized
    }
} else {
    // Dados de autenticação ausentes
    $responseBody = json_encode(['message' => 'Dados de autenticação ausentes']);
    http_response_code(400); // Bad Request
}

echo $responseBody;
?>

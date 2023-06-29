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

// Receber os dados de login enviados pelo formulário
$username = $_POST['username'];
$password = $_POST['password'];

$responseBody = ''; // Variável para armazenar a resposta

if (!empty($username) && !empty($password)) {
    // Consulta para obter as informações do usuário
    $query = "SELECT * FROM tb_usuario WHERE nome = :username AND senha = :password";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    // Verificar se os dados do usuário correspondem às informações fornecidas
    if ($stmt->rowCount() > 0) {
        // Dados do usuário encontrados no banco de dados
        // Realizar as ações necessárias, como gerar um token, retornar uma resposta bem-sucedida, etc.
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Gerar o token (codificar), usando a classe disponível no sistema
        $payload = [
            "id" => $user['id'],
            "username" => $user['nome'],
            "administrador" => $user['administrador'] == 1 ? 1 : 0
        ];
        
        require_once("lib/jwtutil.inc.php");
        require_once("config.php");
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

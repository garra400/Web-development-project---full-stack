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

// Verificar se o usuário está logado
$loggedUserName = '';

// Verificar se o token de autenticação está presente nos cabeçalhos da solicitação
if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    $token = $_SERVER['HTTP_AUTHORIZATION'];

    // Decodificar o token e obter as informações do usuário
    $payload = JwtUtil::decode($token, JWT_SECRET_KEY);
    $loggedUserName = $payload['username'];
}

// Consultar os usuários no banco de dados
$query = "SELECT * FROM tb_usuario";
$stmt = $pdo->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retornar os usuários como uma resposta JSON
header('Content-Type: application/json');
echo json_encode($users);
?>

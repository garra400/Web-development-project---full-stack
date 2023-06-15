<?php
    require_once("lib/jwtutil.inc.php");
    require_once("config.php");

    // Verificar se o token está presente no cookie
    if(isset($_COOKIE["token"])) {
        $token = $_COOKIE["token"];

        // Decodificar o token
        $payload = JwtUtil::decode($token, JWT_SECRET_KEY);

        // Verificar se o token é válido
        if($payload !== false) {
            // O token é válido, o usuário está logado

            // Exibir o nome de usuário
            $username = $payload["username"];
            echo "Olá, $username!";

            // Exibir a opção de deslogar
            echo '<a href="logout.php">Deslogar</a>';
        } else {
            // O token é inválido, redirecionar para a página de login
            header("Location: login.php");
            exit();
        }
    } else {
        // O token não está presente, redirecionar para a página de login
        header("Location: login.php");
        exit();
    }
?>

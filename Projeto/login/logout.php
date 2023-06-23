<?php
function logout() {
        setcookie('token', '', time() - 3600, '/');
        header('Location: index.php');
        exit();
    }
?>
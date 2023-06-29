function validateLogin() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/projeto/login/authenticate.php", true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                var token = response.token;
                // Salvar o token no localStorage
                localStorage.setItem("token", token);
                // Redirecionar o usuário para a página de menu
                window.location.href = "menu.html"; // Substitua "menu.html" pelo nome da sua página de menu
            } else if (xhr.status === 401) {
                var response = JSON.parse(xhr.responseText);
                var message = response.message;
                // Faça algo com a mensagem de erro, como exibi-la na tela
                console.error("Erro de autenticação:", message);
                alert("Erro de autenticação");
                document.getElementById("message").innerHTML = message;
            } else {
                // Outro status de resposta
                console.error("Erro na requisição:", xhr.status);
            }
        }
    };

    var formData = new FormData();
    formData.append("username", username);
    formData.append("password", password);

    xhr.send(formData);
}

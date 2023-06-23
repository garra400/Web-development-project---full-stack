function addTableRow(data) {
  var table = document.getElementById("table-body");
  
  if (!table) {
    console.error("Elemento 'table-body' não encontrado.");
    return;
  }

  var newRow = table.insertRow(table.rows.length);
  var cell = newRow.insertCell(0);

  cell.textContent = data.nome;
}

function getUsers() {
  fetch("http://localhost/projeto/login/get_users.php")
    .then(function (response) {
      if (!response.ok) {
        throw new Error("Erro na requisição. Status do erro: " + response.status);
      }
      return response.json();
    })
    .then(function (data) {
      data.forEach(function (user) {
        addTableRow(user);
      });
    })
    .catch(function (error) {
      console.error("Erro na obtenção de usuários:", error.message);
    });
}

document.addEventListener("DOMContentLoaded", function () {
  getUsers();
});

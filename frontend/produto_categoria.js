// URL base da API de dados da pessoa
const URL = "http://localhost/Projeto/api";

/**
 * Função getAll()
 * Objetivo: Fazer uma requisição HTTP para obter
 * uma lista de usuários em JSON e, posteriormente,
 * atualizar a tabela HTML.
 */
function getAll() {
  // Cliente HTTP faz a requisição para a API
  fetch(`${URL}/categoria/get.php`)
    .then((res) => res.json()) // Convertemos JSON em OBJ
    .then((data) => {
      // Atualiza a tabela HTML
      console.log(data);

      data.forEach((categoria) => {
        addTableRow(categoria);
      });
    });
}

function filtrarTabela() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("filtro");
  filter = input.value.toUpperCase();
  table = document.getElementById("tb_categoria");
  tr = table.getElementsByTagName("tr");

  // Percorre todas as linhas da tabela e oculta aquelas que não correspondem ao filtro
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1]; // Obtém a coluna com o nome do produto
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

/**
 * Função: addTableRow()]
 *
 * Objetivo: adicionar uma linha na tabela HTML.
 */
/**
 * Função: addTableRow()
 *
 * Objetivo: adicionar uma linha na tabela HTML.
 */
function addTableRow(categoria) {
  const table = document.getElementById("tb_categoria");

  // Criando uma linha para adicionar na tabela
  const tr = document.createElement("tr");

  // Primeira célula da linha (tr)
  const td1 = document.createElement("td");
  td1.innerHTML = "Categoria " + categoria.id;

  // Segunda célula da linha (tr)
  const td2 = document.createElement("td");
  td2.innerHTML = categoria.nome;

  // Terceira célula da linha (tr)
  const td3 = document.createElement("td");
  td3.classList.add("checkbox-cell");

  const checkbox = document.createElement("input");
  checkbox.type = "checkbox";
  checkbox.classList.add("checkbox-btn");
  checkbox.addEventListener("change", () => {
    // Lógica para lidar com a seleção/deseleção do checkbox
  });
  const label = document.createElement("label");
  label.appendChild(checkbox);

  const span = document.createElement("span");
  span.classList.add("checkmark");

  label.appendChild(span);

  td3.appendChild(label);

  tr.appendChild(td1);
  tr.appendChild(td2);
  tr.appendChild(td3);

  table.tBodies[0].appendChild(tr);
}


function deleteCategoria(tr, id) {
  console.log("Deletando o ID", id);

  fetch(`${URL}/categoria/delete.php?id=${id}`)
    .then((res) => {
      console.log(res);
      if (res.status == 200) tr.remove();
      else alert("Falha ao remover categoria " + id);
    })
    .catch((err) => {
      console.log(err);
    });
}
/**
 * Função: save
 * Objetivo: Invocar a API, passando os dados do
 * formulário (nome, email, nascimento, ...)
 */
function save() {
  // Obter a referência para os campos input
  const fNome = document.getElementById("fNome");
  const fEmail = document.getElementById("fEmail");
  const fNascimento = document.getElementById("fNascimento");

  // Criar o objeto representando uma categoria, contendo
  // os valores dos inputs
  const categoria = {
    nome: fNome.value
  };

  console.log(categoria);

  // Invocar a API
  fetch(`${URL}/categoria/create.php`, {
    body: JSON.stringify(categoria),
    method: "POST",
    headers: {
      "Content-type": "application/json",
    },
  }).then((res) => {
    if (res.status == 200 || res.status == 201) {
      alert("Salvo com sucesso!");

      res.json().then( pes => {addTableRow(pes)});
    } else alert("Falha ao salvar");
  });
}

// Invocando a função para obter a lista de categorias
// e atualizar o tabela
getAll();

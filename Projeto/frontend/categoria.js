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

/**
 * Função: addTableRow()]
 *
 * Objetivo: adicionar uma linha na tabela HTML.
 */
function addTableRow(categoria) {
  const table = document.getElementById("tbCategoria");

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

  const btRemove = document.createElement("button");
  btRemove.innerHTML = "Excluir";
  btRemove.onclick = () => {
    //alert("Remover " + categoria.nome);
    deleteCategoria(tr, categoria.id);
    2;
  };

  td3.appendChild(btRemove);

  tr.appendChild(td1);
  tr.appendChild(td2);
  tr.appendChild(td3);

  table.tBodies[0].appendChild(tr);
}

/**
 * Objetivo: Deletar um categoria na API e remover a linha da tabela.
 */
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

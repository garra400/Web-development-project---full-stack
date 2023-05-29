// URL base da API de dados da compra
const URL = "http://localhost/Projeto/api";

/**
 * Função getAll()
 * Objetivo: Fazer uma requisição HTTP para obter
 * uma lista de compras em JSON e, posteriormente,
 * atualizar a tabela HTML.
 */
function getAll() {
  // Cliente HTTP faz a requisição para a API
  fetch(`${URL}/compra/get.php`)
    .then((res) => res.json()) // Convertemos JSON em OBJ
    .then((data) => {
      // Atualiza a tabela HTML
      console.log(data);

      data.forEach((compra) => {
        addTableRow(compra);
      });
    });
}

/**
 * Função: addTableRow()]
 *
 * Objetivo: adicionar uma linha na tabela HTML.
 */
function addTableRow(compra) {
  const table = document.getElementById("tbCompra");

  // Criando uma linha para adicionar na tabela
  const tr = document.createElement("tr");

  // Primeira célula da linha (tr)
  const td1 = document.createElement("td");
  td1.innerHTML = "Compra " + compra.id;

  // Segunda célula da linha (tr)
  const td2 = document.createElement("td");
  td2.innerHTML = compra.id_usuario;

  // Terceira célula da linha (tr)
  const td6 = document.createElement("td");

  const btRemove = document.createElement("button");
  btRemove.innerHTML = "Excluir";
  btRemove.onclick = () => {
    //alert("Remover " + compra.id_usuario);
    deleteCompra(tr, compra.id);
    2;
  };

  td6.appendChild(btRemove);

  tr.appendChild(td1);
  tr.appendChild(td2);
  tr.appendChild(td3);
  tr.appendChild(td4);
  tr.appendChild(td5);
  tr.appendChild(td6);

  table.tBodies[0].appendChild(tr);
}

/**
 * Objetivo: Deletar um compra na API e remover a linha da tabela.
 */
function deleteCompra(tr, id) {
  console.log("Deletando o ID", id);

  fetch(`${URL}/compra/delete.php?id=${id}`)
    .then((res) => {
      console.log(res);
      if (res.status == 200) tr.remove();
      else alert("Falha ao remover compra " + id);
    })
    .catch((err) => {
      console.log(err);
    });
}

/**
 * Função: save
 * Objetivo: Invocar a API, passando os dados do
 * formulário
 */
function save() {
  // Obter a referência para os campos input
  const fId_Usuario = document.getElementById("fId_Usuario");
  
  // Criar o objeto representando um compra, contendo
  // os valores dos inputs
  const compra = {
    id_usuario: fId_Usuario.value,
  };

  console.log(compra);

  // Invocar a API
  fetch(`${URL}/compra/create.php`, {
    body: JSON.stringify(compra),
    method: "POST",
    headers: {
      "Content-type": "application/json",
    },
  }).then((res) => {
    if (res.status == 200 || res.status == 201) {
      res.json().then( pro => {addTableRow(pro)});
      alert("Compra criado! Por favor, agora selecione as categorias em que ele se encaixa");
      window.open("http://localhost/projeto/frontend/comPro.html", "_self");
      getAll();
      
    } else alert("Falha ao salvar");
  });
}

/**
 * Função: addTableRowCat()]
 *
 * Objetivo: adicionar uma linha na tabela HTML.
 */
function addTableRowCat(categoria) {
  let selectCat = document.getElementById('categorias');
  const table = document.getElementById("tbCategoria");
  let opt = document.createElement('option');
  opt.value = "UF" + i; //Setando o valor do elemento
  opt.innerText = categoria.id_usuario;; //Setando o texto que vai aparecer dentro do select
  selectCat.appendChild(opt); //Adicionamos um elemento filho no select de UFs
} 


// Invocando a função para obter a lista de compras
// e atualizar o tabela
getAll();
// URL base da API de dados da produto
const URL = "http://localhost/Projeto/api";

/**
 * Função getAll()
 * Objetivo: Fazer uma requisição HTTP para obter
 * uma lista de produtos em JSON e, posteriormente,
 * atualizar a tabela HTML.
 */
function getAll() {
  // Cliente HTTP faz a requisição para a API
  fetch(`${URL}/produto/get.php`)
    .then((res) => res.json()) // Convertemos JSON em OBJ
    .then((data) => {
      // Atualiza a tabela HTML
      console.log(data);

      data.forEach((produto) => {
        addTableRow(produto);
      });
    });
}

/**
 * Função: addTableRow()]
 *
 * Objetivo: adicionar uma linha na tabela HTML.
 */
function addTableRow(produto) {
  const table = document.getElementById("tbProduto");

  // Criando uma linha para adicionar na tabela
  const tr = document.createElement("tr");

  // Primeira célula da linha (tr)
  const td1 = document.createElement("td");
  td1.innerHTML = "Produto " + produto.id;

  // Segunda célula da linha (tr)
  const td2 = document.createElement("td");
  td2.innerHTML = produto.nome;

  // Terceira célula da linha (tr)
  const td3 = document.createElement("td");
  td3.innerHTML = produto.descricao;

  // Quarta célula da linha (tr)
  const td4 = document.createElement("td");
  td4.innerHTML = produto.preco;

  // Quinta célula da linha (tr)
  const td5 = document.createElement("td");
  td5.innerHTML = produto.quantidade;

  // Sexta célula da linha (tr)
  const td6 = document.createElement("td");

  const btRemove = document.createElement("button");
  btRemove.innerHTML = "Excluir";
  btRemove.onclick = () => {
    //alert("Remover " + produto.nome);
    deleteProduto(tr, produto.id);
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
 * Objetivo: Deletar um produto na API e remover a linha da tabela.
 */
function deleteProduto(tr, id) {
  console.log("Deletando o ID", id);

  fetch(`${URL}/produto/delete.php?id=${id}`)
    .then((res) => {
      console.log(res);
      if (res.status == 200) tr.remove();
      else alert("Falha ao remover produto " + id);
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
  const fNome = document.getElementById("fNome");
  const fDescricao = document.getElementById("fDescricao");
  const fPreco = document.getElementById("fPreco");
  const fQuantidade = document.getElementById("fQuantidade");
  
  // Criar o objeto representando um produto, contendo
  // os valores dos inputs
  const produto = {
    nome: fNome.value,
    descricao: fDescricao.value,
    preco: fPreco.value,
    quantidade: fQuantidade.value
  };

  console.log(produto);

  // Invocar a API
  fetch(`${URL}/produto/create.php`, {
    body: JSON.stringify(produto),
    method: "POST",
    headers: {
      "Content-type": "application/json",
    },
  }).then((res) => {
    if (res.status == 200 || res.status == 201) {
      res.json().then( pro => {addTableRow(pro)});
      alert("Produto criado! Por favor, agora selecione as categorias em que ele se encaixa");
      window.open("http://localhost/projeto/frontend/proCat.html", "_self");
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
  opt.innerText = categoria.nome;; //Setando o texto que vai aparecer dentro do select
  selectCat.appendChild(opt); //Adicionamos um elemento filho no select de UFs
} 


// Invocando a função para obter a lista de produtos
// e atualizar o tabela
getAll();
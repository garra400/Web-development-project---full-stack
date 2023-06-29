// URL base da API de dados da produto
const URL = "http://localhost/Projeto/api";

let categorias = [];

/**
 * Função getAll()
 * Objetivo: Fazer uma requisição HTTP para obter
 * uma lista de produtos em JSON e, posteriormente,
 * atualizar a tabela HTML.
 */
function getAll() {
  // Cliente HTTP faz a requisição para a API
  getAllCategorias();
  fetch(`${URL}/produto/get.php`)
    .then((res) => res.json()) // Convertemos JSON em OBJ
    .then((data) => {
      //Atualiza a tabela HTML
      //console.log(data);
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
  const table = document.getElementById("tb_produto");

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
  const cat = categorias.find( e => e.id == produto.id_categoria);
  td6.innerHTML =  cat ? cat.nome : ""; //IF ternário para achar o nome da categoria através do ID dela

  // Sétima célula da linha (tr)
  const td7 = document.createElement("td");

  const btAtualiza = document.createElement("button");
  btAtualiza.innerHTML = "Atualizar";
  btAtualiza.onclick = () => {
    //alert("Atualizar " + produto.nome);
    updateProduto(tr, produto.id);
    window.open("http://localhost/projeto/frontend/produto.html", "_self")
  };


  // Oitava célula da linha (tr)
  const td8 = document.createElement("td");

  const btRemove = document.createElement("button");
  btRemove.innerHTML = "Excluir";
  btRemove.onclick = () => {
    //alert("Remover " + produto.nome);
    deleteProduto(tr, produto.id);
  };

  td7.appendChild(btAtualiza);
  td8.appendChild(btRemove);

  tr.appendChild(td1);
  tr.appendChild(td2);
  tr.appendChild(td3);
  tr.appendChild(td4);
  tr.appendChild(td5);
  tr.appendChild(td6);
  tr.appendChild(td7);
  tr.appendChild(td8);

  table.tBodies[0].appendChild(tr);
}

function filtrarTabela() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("filtro");
  filter = input.value.toUpperCase();
  table = document.getElementById("tb_produto");
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
  const fCategoria = document.getElementById("categorias");

  // Criar o objeto representando um produto, contendo
  // os valores dos inputs
  const produto = {
    nome: fNome.value,
    descricao: fDescricao.value,
    preco: fPreco.value,
    quantidade: fQuantidade.value,
    id_categoria: fCategoria.value
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
      res.json().then(pro => { addTableRow(pro) });
      alert("Produto criado!");
      //window.open("http://localhost/projeto/frontend/proCat.html", "_self"); //Apenas para manter o código se necessária reutilizar
    } else alert("Falha ao salvar");
  });
}

/**
 * Função getAllCategorias()
 * Objetivo: Fazer uma requisição HTTP para obter
 * uma lista de produtos em JSON e, posteriormente,
 * atualizar a tabela HTML.
 */

function getAllCategorias() {
  // Cliente HTTP faz a requisição para a API
  fetch(`${URL}/categoria/get.php`)
    .then((res) => res.json()) // Convertemos JSON em OBJ
    .then((data) => {
      data.forEach((categoria) => {
        categorias = data;
        addOptionSelect(categoria);
      });
    });
}

/**
 * Função: addOptionSelect()]
 *
 * Objetivo: adicionar uma linha no select.
 */
function addOptionSelect(categoria) {
  let selectCat = document.getElementById('categorias');
  let opt = document.createElement('option');
  opt.value = categoria.id; //Setando o valor do elemento
  opt.innerText = categoria.nome; //Setando o texto que vai aparecer dentro do select
  selectCat.appendChild(opt);
}

/**
 * Função: updateProduto
 * Objetivo: Invocar a API, passando os dados do
 * formulário (nome, email, nascimento, ...)
 */
function updateProduto(tr, id) {
  console.log("Atualizando o ID", id);
  // Obter a referência para os campos input
  const fNome = document.getElementById("fNome");
  const fDescricao = document.getElementById("fDescricao");
  const fPreco = document.getElementById("fPreco");
  const fQuantidade = document.getElementById("fQuantidade");
  const fCategoria = document.getElementById("categorias");

  // Criar o objeto representando um produto, contendo
  // os valores dos inputs
  const produto = {
    nome: fNome.value,
    descricao: fDescricao.value,
    preco: fPreco.value,
    quantidade: fQuantidade.value,
    id_categoria: fCategoria.value
  };

  console.log(produto);

  // Invocar a API
  fetch(`${URL}/produto/update.php?id=${id}`, {
    body: JSON.stringify(produto),
    method: "POST",
    headers: {
      "Content-type": "application/json",
    },
  }).then((res) => {
    if (res.status == 200 || res.status == 201) {
      alert("Atualizado com sucesso!");
      //res.json().then( pes => {addTableRow(pes)});
    } else alert("Falha ao salvar");
  });
}

// Invocando a função para obter a lista de produtos
// e atualizar o tabela
getAll();
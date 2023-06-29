// URL base da API de dados da pessoa
const URL = "http://localhost/Projeto/api";

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
  const fSenha = document.getElementById("fSenha");

  // Criar o objeto representando uma pessoa, contendo
  // os valores dos inputs
  const usuario = {
    nome: fNome.value,
    email: fEmail.value,
    nascimento: fNascimento.value,
    senha: fSenha.value
  };

  console.log(usuario);

  // Invocar a API
  fetch(`${URL}/usuario/create.php`, {
    body: JSON.stringify(usuario),
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
CREATE TABLE tb_usuario(
    id INT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100),
    senha VARCHAR(100),
    nascimento DATE,
    administrador INT
);

CREATE TABLE tb_produto(
    id INT PRIMARY KEY,
    nome VARCHAR(100),
    descricao VARCHAR(100),
    preco FLOAT,
    quantidade INT
);

CREATE TABLE tb_categoria(
    id INT PRIMARY KEY,
    nome VARCHAR(100)
);

CREATE TABLE tb_produto_categoria(
    id_produto INT,
    id_categoria INT,
    PRIMARY KEY (id_produto, id_categoria),
    FOREIGN KEY (id_produto) REFERENCES tb_produto (id),
    FOREIGN KEY (id_categoria) REFERENCES tb_categoria (id)
);

CREATE TABLE tb_compra(
    id INT PRIMARY KEY, 
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES tb_usuario (id)
);

CREATE TABLE tb_compra_produto(
    id_compra INT,
    id_produto INT,
    PRIMARY KEY (id_compra, id_produto),
    FOREIGN KEY (id_compra) REFERENCES tb_compra (id),
    FOREIGN KEY (id_produto) REFERENCES tb_produto (id),
    quantidade FLOAT
);

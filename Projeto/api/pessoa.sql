CREATE  TABLE tb_pessoa (
    id INTEGER NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nascimento date,
	PRIMARY KEY (id)
);


INSERT INTO tb_pessoa (nome, 
     email, 
     senha, 
     telefone, 
     nascimento ) 
    VALUES (
        'Juca Oliveira', 
        'juca@a.com', 
        '1234', 
        '4544444', 
        '2002-05-05'
    )

--Para a tabela usuário
--create table tb_usuario(id integer not null auto_increment, nome varchar(100) not null, nascimento date, email varchar(100), senha varchar(255), administrador integer null, primary key(id));
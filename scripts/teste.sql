CREATE TABLE categorias(
	id SERIAL primary key,
	nome varchar(50) not null
);

CREATE TABLE produtos(
	id SERIAL primary key,
	nome varchar(100) not null,
	quantidade int not null,
	categoria int not null,
	foreign key(categoria) references categorias(id)
);

INSERT INTO categorias(nome)
VALUES('Esportes'),
('Eletrônicos'),
('Lazer');



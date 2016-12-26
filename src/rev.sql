CREATE DATABASE rev;
USE rev;

CREATE TABLE tb_usuarios (
	idusuario INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nreusou TINYINT(1) UNSIGNED NOT NULL,
	txtapelido VARCHAR(128) NOT NULL,
	txtemail VARCHAR(64) NOT NULL,
	txtsenha CHAR(32) NOT NULL,
	isconfirmed BOOLEAN NOT NULL DEFAULT FALSE,
	dtcadastro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tb_visitas (
	idvisita INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idusuario INT(11) UNSIGNED NULL DEFAULT NULL,
	txtsessionid VARCHAR(128) NOT NULL,
	txtip VARCHAR(64) NOT NULL,
	txtcookie VARCHAR(64) NOT NULL,
	txtuseragent VARCHAR(256) NOT NULL,
	txtcomefrom VARCHAR(256) NOT NULL,
	isjs BOOLEAN NOT NULL DEFAULT FALSE,
	nrscreenwidth INT(11) UNSIGNED DEFAULT NULL,
	nrscreenheight INT(11) UNSIGNED DEFAULT NULL,
	txtlanguage VARCHAR(32) DEFAULT NULL,
	nrfirstajax BIGINT(16) UNSIGNED DEFAULT NULL,
	nrlasttajax BIGINT(16) UNSIGNED DEFAULT NULL,
	txtjssystem VARCHAR(32) DEFAULT NULL,
	txtjsbrowser VARCHAR(32) DEFAULT NULL,
	dtcadastro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tb_natureza (
	idnatureza INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	txtnatureza VARCHAR(64) NOT NULL,
	isactive BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE tb_comentarios (
	idcomentario INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idusuario INT(11) UNSIGNED NOT NULL,
	idnatureza INT(11) UNSIGNED NOT NULL,
	idparent INT(11) UNSIGNED NOT NULL DEFAULT 0,
	txtcomentario TEXT NOT NULL,
	dtcadastro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tb_comentarios_curtidos (
	idcomentario INT(11) UNSIGNED NOT NULL,
	idusuario INT(11) UNSIGNED NOT NULL
);

ALTER TABLE tb_usuarios
	ADD CONSTRAINT uq_usuarios_txtemail UNIQUE (txtemail);

ALTER TABLE tb_visitas
	ADD CONSTRAINT fk_visitas_idusuario FOREIGN KEY (idusuario)
		REFERENCES tb_usuarios(idusuario);
		
ALTER TABLE tb_comentarios
	ADD CONSTRAINT fk_comentarios_idusuario FOREIGN KEY (idusuario)
		REFERENCES tb_usuarios(idusuario),
	ADD CONSTRAINT fk_comentarios_idnatureza FOREIGN KEY (idnatureza)
		REFERENCES tb_natureza(idnatureza);

ALTER TABLE tb_comentarios_curtidos
	ADD CONSTRAINT pk_comentarios_curtidos PRIMARY KEY (idcomentario, idusuario),
	ADD CONSTRAINT fk_comentarios_curtidos_idcomentario FOREIGN KEY (idcomentario)
		REFERENCES tb_comentarios(idcomentario),
	ADD CONSTRAINT fk_comentarios_curtidos_idusuario FOREIGN KEY (idusuario)
		REFERENCES tb_usuarios(idusuario);

INSERT INTO tb_natureza (txtnatureza) VALUES ('Tópico do Forúm'), ('Frase'), ('Comentário de Frase');

 -- ADIÇÕES DE 18/06/2013
CREATE TABLE tb_forums (
	idforum INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nrpos INT(11) UNSIGNED NOT NULL,
	txtforum VARCHAR(32) NOT NULL,
	txtdescricao VARCHAR(128) NOT NULL,
	isactive BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE tb_topicos (
	idtopico INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idforum INT(11) UNSIGNED NOT NULL,
	idusuario INT(11) UNSIGNED NOT NULL,
	txttopico VARCHAR(128) NOT NULL,
	dtcadastro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE tb_forums
	ADD CONSTRAINT uq_topicos_nrpos UNIQUE (nrpos);

ALTER TABLE tb_topicos
	ADD CONSTRAINT fk_topicos_idforum FOREIGN KEY (idforum)
		REFERENCES tb_forums (idforum),
	ADD CONSTRAINT fk_topicos_idusuario FOREIGN KEY (idusuario)
		REFERENCES tb_usuarios (idusuario);

INSERT INTO tb_forums (txtforum, txtdescricao, nrpos) VALUES
	('Geral', 'Sessão aberta para tópicos relacionados a manifestação', 1),
	('Eventos', 'Divulgação de manifestação em qualquer lugar', 2),
	('Notícias', 'Públique as notícias que você conhecer nesta sessão', 3),
	('Sobre o site', 'Você que é designer ou programador dê dicas à nossos webmasters sobre como melhorar o site', 4),
	('Suporte', 'Perguntas sobre como usar o site', 5),
	('Outros', 'Para criar tópicos relacionados com outros assunto, utilize essa sessão', 6);
	
DELIMITER ;;
CREATE PROCEDURE sp_forums_list
BEGIN
	SELECT idforum, txtforum, txtdescricao FROM tb_forums WHERE isactive = 1 ORDER BY nrpos
END ;;
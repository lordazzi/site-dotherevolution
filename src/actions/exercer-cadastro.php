<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/resource/config.php");

$nome = post("nome");
$email = post("email");
$senha = $_POST["senha"];
$confirm = $_POST["confirm"]; //	não tem necessidade de tratamento, já que é convertido para MD5 antes de entrar no banco
$voceeh = post("voce-eh");
if (
	!$_POST OR !$nome OR !$email OR !$senha OR !$voceeh OR
	!@preg_match($nome, "/^[A-Za-zÁÉÍÓÚÀÈIÒÙÃÕÑÇÜáéíóúàèìòúãõñçü -]+$/") OR
	strlen($nome) < 6 OR strlen($senha) < 6 OR $senha <> $confirm OR 
	!@preg_match($email, "/^([0-9a-zA-Z]+([_.-]?[0-9a-zA-Z]+)*@[0-9a-zA-Z]+[0-9,a-z,A-Z,.,-]*[.]{1}[a-zA-Z]{2,4})+$/") OR
	in_array($voceeh, array("1", "2", "3", "4", "5"))
) {	
	$sql = new MySql();
	$sql->Query("
		INSERT INTO
			tb_usuarios (
				nreusou, txtapelido,
				txtemail, txtsenha
			) VALUES (
				$voceeh, '$nome',
				'$email', '".MD5($senha)."'
			)");
	
	$idusuario = $sql->lastId();
	$confirmation = base64_encode(MD5($idusuario.$email));
	$_SESSION["idusuario"] = $idusuario;
	$_SESSION["nreusou"] = $voceeh;
	$_SESSION["txtapelido"] = $nome;
	$_SESSION["txtemail"] = $email;
	$_SESSION["isconfirmed"] = 0;
	
	//	Não faz sentido confirmar o e-mail quando não se tem o dominio ainda
	// sendMail(array(
		// "to" => $email,
		// "assunto" => "Confirmação de E-mail",
		// "mensagem" => "Bem vindo ao movimento em prol do Brasil! <br />"
	// ));
	
	callback(array(
		"success" => TRUE
	));
}

callback(array(
	"success" => FALSE
));


?>
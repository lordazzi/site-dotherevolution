<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/resource/config.php");

if ($_POST AND $_POST["frase"] <> "") {
	$frase = post("frase");

	try {
		$frase = substr($frase, 0, 160);
		$sql = new MySql();
		$sql->Query("
			INSERT INTO
				tb_comentarios
					(
						idusuario, idnatureza, txtcomentario
					) VALUES (
						$_SESSION[idusuario], 2, '$frase'
					)");
				
		callback(array(
			"success" => TRUE,
			"autor" => $_SESSION["txtapelido"],
			"frase" => $frase
		));
	} catch (Exception $e) {
		callback(array(
			"success" => FALSE,
			"msg" => "Atenção, ocorreu um erro não previsto."
		));
	}
} else {
	callback(array(
		"success" => FALSE,
		"msg" => "Atenção, nenhuma informação foi enviada."
	));
}

?>
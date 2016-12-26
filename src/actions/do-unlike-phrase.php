<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/resource/config.php");

if (is_numeric($_POST["id"])) {
	try {
		$id = post("id");
		$sql = new MySql();
		$sql->Query("DELETE FROM tb_comentarios_curtidos WHERE idcomentario=$id AND idusuario=$_SESSION[idusuario]");
		callback(array(
			"success" => TRUE
		));
	} catch (Exception $e) {
		callback(array(
			"success" => FALSE
		));
	}
}
callback(array(
	"success" => FALSE
));
?>
<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/resource/config.php");

$sql = new MySql();
$frases = $sql->Query("SELECT b.txtapelido, a.txtcomentario, a.dtcadastro
	FROM tb_comentarios a
	INNER JOIN tb_usuarios b on a.idusuario = b.idusuario
	ORDER BY a.dtcadastro
	LIMIT 0 , 10");

foreach ($frases as &$frase) {
	$frase["dtcadastro"] = date("d/m/Y H:i:s", $frase["dtcadastro"]);
}
	
$rev = new Rev(array(
	"html" => array(
		"frases" => $frases
	),
	"js" => TRUE,
	"less" => TRUE
));
?>
<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/resource/config.php");

$sql = new MySql();
$idusuario = ($_SESSION["idusuario"]) ? ($_SESSION["idusuario"]) : (0);
$frases = $sql->Query("
	SELECT subtable.idcomentario, subtable.txtapelido, subtable.txtcomentario,
		subtable.dtcadastro, subtable.isactive, COUNT(coments.idcomentario) AS nrquantidade
	FROM (SELECT
		a.idcomentario, b.txtapelido, a.txtcomentario,
		a.dtcadastro, COUNT(d.idusuario) AS isactive
	FROM tb_comentarios a
	INNER JOIN tb_usuarios b ON a.idusuario = b.idusuario
	LEFT JOIN tb_comentarios_curtidos d ON a.idcomentario = d.idcomentario AND d.idusuario = $idusuario
	GROUP BY a.idcomentario, b.txtapelido, a.txtcomentario, a.dtcadastro) AS subtable
	LEFT JOIN tb_comentarios_curtidos coments ON coments.idcomentario = subtable.idcomentario
	GROUP BY subtable.idcomentario, subtable.txtapelido, subtable.txtcomentario,
		subtable.dtcadastro, subtable.isactive
	ORDER BY nrquantidade DESC, subtable.dtcadastro
	LIMIT 0 , 15
");
	
foreach ($frases as &$frase) {
	$frase["dtcadastro"] = date("d/m/Y H:i:s", $frase["dtcadastro"]);
	if ($frase["isactive"] == TRUE) {
		$frase["isactive"] = "un";
	} else {
		$frase["isactive"] = "";
	}
}

$rev = new Rev(array(
	"html" => array(
		"login" => (bool) @$_SESSION["idusuario"],
		"frases" => $frases
	),
	"less" => TRUE,
	"js" => array( "jqueryui" ),
	"cache" => FALSE
));

?>
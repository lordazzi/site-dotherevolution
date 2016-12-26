<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/resource/config.php");

$sql = new MySql();
$forums = $sql->Query("SELECT idforum, txtforum, txtdescricao FROM tb_forums WHERE isactive = 1 ORDER BY nrpos");
foreach($forums as &$forum) {
	$forum["topicos"] = $sql->Query("
		SELECT a.idtopico, a.idusuario, a.txttopico, b.txtapelido, a.dtcadastro
		FROM tb_topicos a
		INNER JOIN tb_usuarios b ON a.idusuario = b.idusuario
		WHERE a.idforum = $forum[idforum]
	");
	
	// foreach ($forum["topicos"] as &$topicos) {
		// $topicos["dtcadastro"]
	// }
}

$rev = new Rev(array(
	"html" => array(
		"forums" => $forums
	),
	"less" => TRUE
));

?>
<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/resource/config.php");

$sessionid = session_id();
$time = post("secondajax");

if (is_numeric($time)) {
	$sql = new MySql();
	$sql->Query("UPDATE tb_visitas SET nrlasttajax=$time WHERE isjs = 1 AND txtsessionid = '$sessionid' AND nrfirstajax <> 0");
}

?>
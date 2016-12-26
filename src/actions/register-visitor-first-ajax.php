<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/resource/config.php");

$sessionid = session_id();
$width = post("width");
$height = post("height");
$time = post("firstajax");
$lang = strtolower(post("language"));
$browser = strtolower(post("browser"));
$system = post("system");

$sql = new MySql();
$is = $sql->Query("SELECT COUNT(*) as total FROM tb_visitas WHERE isjs = 0 AND txtsessionid = '$sessionid'", TRUE);

if ($is["total"] != 0 AND is_numeric($width) AND is_numeric($height) AND is_numeric($time)) {
	$sql->Query("
		UPDATE tb_visitas
		SET
			isjs = TRUE,
			nrscreenwidth = $width,
			nrscreenheight = $height,
			txtlanguage = '$lang',
			nrfirstajax = $time,
			txtjssystem = '$system',
			txtjsbrowser = '$browser'
		WHERE isjs = 0 AND txtsessionid = '$sessionid'
	");
	
	callback(array(
		"success" => TRUE
	));
}

callback(array(
	"success" => FALSE
));
?>
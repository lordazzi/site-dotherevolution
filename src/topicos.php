<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/resource/config.php");

$sql = new MySql();
// $sql->Query();

$rev = new Rev(array(
	"html" => TRUE,
	"less" => TRUE
));
?>
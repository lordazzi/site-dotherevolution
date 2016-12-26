<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/resource/config.php");

$q = str_replace("'", "´", $_SERVER["QUERY_STRING"]);
$sql = new MySql();
$sql->Query("UPDATE tb_usuarios SET isconfirmed=1 WHERE MD5(idusuario+txtemail) = '".base64_decode($q)."'");
redirect("frases.php");
?>
<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/resource/config.php");

$login = post("auth-login");
$senha = MD5(post("auth-senha"));


$sql = new MySql();
$user = $sql->Query("SELECT idusuario, nreusou, txtapelido, txtemail, isconfirmed FROM tb_usuarios WHERE txtemail = '$login' AND txtsenha='$senha'", TRUE);

if (count($user) > 0) {
	$sessionid = session_id();
	$sql->Query("UPDATE tb_visitas SET idusuario=$user[idusuario] WHERE txtsessionid='$sessionid' AND idusuario IS NULL");
	
	$_SESSION["idusuario"] = $user["idusuario"];
	$_SESSION["nreusou"] = $user["nreusou"];
	$_SESSION["txtapelido"] = $user["txtapelido"];
	$_SESSION["txtemail"] = $user["txtemail"];
	$_SESSION["isconfirmed"] = $user["isconfirmed"];
	
	callback(array(
		"success" => TRUE
	));
} else {
	callback(array(
		"success" => FALSE
	));
}
?>
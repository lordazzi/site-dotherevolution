<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/resource/config.php");

unset($_SESSION["idusuario"]);
unset($_SESSION["nreusou"]);
unset($_SESSION["txtapelido"]);
unset($_SESSION["txtemail"]);
unset($_SESSION["isconfirmed"]);

callback(array(
	"success" => TRUE
));
?>
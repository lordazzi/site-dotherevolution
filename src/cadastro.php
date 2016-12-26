<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/resource/config.php");

$rev = new Rev(array(
	"html" => TRUE,
	"less" => TRUE,
	"js" => array( "forms", "tooltip" )
));
?>
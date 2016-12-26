<?php

session_start();
// parse_str(base64_decode($_SERVER["QUERY_STRING"]), $_GET);
date_default_timezone_set("Brazil/East");

function __autoload($class) {
	$class = strtolower($class);
	if (file_exists($_SERVER["DOCUMENT_ROOT"]."/resource/php/class/$class.class.php")) {
		require_once($_SERVER["DOCUMENT_ROOT"]."/resource/php/class/$class.class.php");
	}
}

require_once($_SERVER["DOCUMENT_ROOT"]."/resource/php/functions.php");
?>
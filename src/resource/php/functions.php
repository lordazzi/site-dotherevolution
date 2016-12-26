<?php
/** constantes */
define("isIE", (bool) stristr($_SERVER["HTTP_USER_AGENT"], "MSIE"));
define("isIE6", (bool) stristr($_SERVER["HTTP_USER_AGENT"], "MSIE 6"));
define("isIE7", (bool) stristr($_SERVER["HTTP_USER_AGENT"], "MSIE 7"));
define("isIE8", (bool) stristr($_SERVER["HTTP_USER_AGENT"], "MSIE 8"));
define("isIE9", (bool) stristr($_SERVER["HTTP_USER_AGENT"], "MSIE 9"));
define("isIE10", (bool) stristr($_SERVER["HTTP_USER_AGENT"], "MSIE 10"));

define("isFirefox", (bool) stristr($_SERVER["HTTP_USER_AGENT"], "firefox"));
define("isOpera", (stristr($_SERVER["HTTP_USER_AGENT"], "opera") or stristr($_SERVER["HTTP_USER_AGENT"], "presto")));

define("isWebKit", (bool) stristr($_SERVER["HTTP_USER_AGENT"], "AppleWebKit"));
define("isSafari", (stristr($_SERVER["HTTP_USER_AGENT"], "AppleWebKit") and stristr($_SERVER["HTTP_USER_AGENT"], "Gecko) Version")));
define("isChrome", (stristr($_SERVER["HTTP_USER_AGENT"], "AppleWebKit") and stristr($_SERVER["HTTP_USER_AGENT"], "Gecko) Chrome")));

/** da utf8_decode nas informações se for necessario */
function decode($string) {
	$enc = mb_detect_encoding($string.'x', 'UTF-8, ISO-8859-1');
	if ($enc == "UTF-8") {
		$string = utf8_decode($string);
	}
	return $string;
}

/** da utf8_encode nas informações se for necessario */
function encode($string) {
	$enc = mb_detect_encoding($string.'x', 'UTF-8, ISO-8859-1');
	if ($enc == "ISO-8859-1") {
		$string = utf8_encode($string);
	}
	return $string;
}

/** dá utf8_encode em todo um array */
function array_encode($arr) {
	if ($arr <> FALSE and gettype($arr) == "array") {
		foreach ($arr as &$ar) {
			if (gettype($ar) == "array") {
				$ar = array_encode($ar);
			} else if (gettype($ar) == "string") {
				$ar = encode($ar);
			}
		}
		return $arr;
	} else {
		return array();
	}
}

/** Dá um callback do PHP para o Javascript em json */
function callback($array = array()) {
	echo(json_encode(array_encode($array))); exit();
}

/** trabalhando com o post */
function post($post, $tags = FALSE) {
	if (!$tags) {
		return strip_tags(trim(str_replace("'", "´", $_POST[$post])));
	} else {
		return trim(str_replace("'", "´", $_POST[$post]));
	}
}

/** trabalhando com o get */
function get($get, $tags = FALSE) {
	if (!$tags) {
		return strip_tags(trim(str_replace("'", "´", $_GET[$get])));
	} else {
		return trim(str_replace("'", "´", $_GET[$get]));
	}
}

/** forçando redirecionamento */
function redirect($to) {
	header("location: $to");
	echo("
		<script type='text/javascript'>
			window.location.ref = '$to';
		</script>
	");
}

/** Cria uma pasta com suas subpastas no caso desta não existir */
function mksubdir($newdir, $chmod = 0777) {
	$dirs = explode("/", $newdir);
	$complete = "";
	foreach ($dirs as $dir) {
		if (!is_dir($complete.$dir) AND !($dir == ".." OR $dir == "")) {
			if (!mkdir($complete.$dir, $chmod)) {
				return FALSE; //sem permissão de usuário para criar pasta
			}
		}
		$complete .= $dir."/";
	}
	return $complete;
}

/** Pega a extenção do arquivo */
function get_file_extension($file) {
	$file = explode(".", $file);
	return $file[count($file) - 1];
}

/**
	sendMail(array(
		"to" => email
	))
*/
function sendMail($config) {
	$email = "manifestacaobrasileira@gmail.com";
	
	$mailer = new PHPMailer();
	$mailer->IsSMTP();
	$mailer->SMTPAuth = TRUE;
	
	$mailer->Mailer = "smtp";
	$mailer->SMTPSecure = 'ssl';
	$mailer->Host = "74.125.134.108";
	$mailer->Port = 465;
	
	$mailer->Username = $email;
	$mailer->Password = base64_decode("Njc5MTI4NnEycDk3cnI2");
	
	$mailer->From = $email;
	$mailer->FromName = "Manifestação Brasileira";
	
	if (gettype($config["to"]) == "string") {
		$config["to"] = str_replace(" ", "", $config["to"]);
		$config["to"] = explode(";", $config["to"]);
	}
	
	foreach ($config["to"] as $to) {
		$mailer->AddAddress($to);
	}
	$mailer->IsHTML(TRUE);
	$mailer->Subject = $config["assunto"];
	$mailer->Body = $config["mensagem"];
	
	if($mailer->Send()){
		return TRUE;
	} else {
		//	$sql = new MySql();
		//	criar essa tabela depois
		//	$sql->Query("INSERT INTO `logs` (txttipo, txtlog, dtcadastro) VALUES ('Erro na classe mail', '".$mailer->ErrorInfo."', NOW())");
		return FALSE;
	}
}
?>
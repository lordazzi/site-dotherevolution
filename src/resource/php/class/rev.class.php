<?php

class Rev extends Page {
	private $sql;
	
	public function __construct($args = array()) {
		$sql = new MySql();
			
		$sessionid = session_id();
		
		$is = $sql->Query("SELECT COUNT(*) as total FROM tb_visitas WHERE txtsessionid = '$sessionid'", TRUE);
		if ($is["total"] == 0) {
			//	informações em geral
			$idusuario = ($_SESSION["idusuario"]) ? ($_SESSION["idusuario"]) : ("NULL");
			$ip = System::getIp(TRUE);
			$useragent = $_SERVER["HTTP_USER_AGENT"];
			$from = ($_SERVER["HTTP_REFERER"] != "") ? ($_SERVER["HTTP_REFERER"]) : ("");
			
			//	cookie
			$cookie = ($_COOKIE["visitor"] != "") ? ($_COOKIE["visitor"]) : (MD5(time().$sessionid));
			if (!$_COOKIE["visitor"]) { setcookie("visitor", $cookie, time()+(60*60*24*365)); }
			
			$sql->Query("
				INSERT INTO tb_visitas (
					idusuario, txtsessionid, txtip,
					txtcookie, txtuseragent, txtcomefrom
				) VALUES (
					$idusuario, '$sessionid', '$ip',
					'$cookie', '$useragent', '$from'
				)
			");
		}
		
		parent::__construct(array(
			"header" => "/resource/html/head.html",
			"body" => "/resource/html/body.php",
			"footer" => "/resource/html/footer.html"
		), $args);
	}
	
	public function __destruct() {
		parent::__destruct();
	}
}

?>
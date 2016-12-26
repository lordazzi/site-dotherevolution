<?php
# AUTHOR: RICARDO AZZI #

class Page {
	private $args;
	private $files;
	private $tpl;
	protected $path = "";
	
	public function __construct($files = array(), $args = array()) {
		$cache = "";
		$this->args = $args;
		$this->files = $files;
		
		//	iniciando informações que devem ser colocadas no cabeçalho
		if (@$this->files["header"]) {
			if (@$this->args["cache"] === FALSE) {
				$header = file_get_contents($_SERVER["DOCUMENT_ROOT"].$this->path.@$this->files["header"]);
				$header = str_replace(".js", ".js?_=".time(), $header);
				$header = str_replace(".css", ".css?_=".time(), $header);
				echo($header);
			} else {
				require_once($_SERVER["DOCUMENT_ROOT"].$this->path.@$this->files["header"]);
			}
		}
		
		if (@$this->args["cache"] === FALSE) { $cache = "?_=".time(); }
		
		//	importando arquivos CSS ou LESS espelhados
		if (@$this->args["css"] and !@$this->args["less"]) {
			echo("\r\n\t\t<link rel='stylesheet' href='".$this->getMirror("css")."$cache' />");
		}
		
		if (@$this->args["less"]) {
			if (@$this->args["cache"] === FALSE) {
				echo("\r\n\t\t<link rel='stylesheet' href='".$this->getMirror("less")."&_=".time()."' />");
			} else {
				echo("\r\n\t\t<link rel='stylesheet' href='".$this->getMirror("less")."' />");
			}
		}
		
		//	importando CSS de compatibilidade para todas as páginas
		if (is_array(@$this->args["main"]["css"])) {
			$this->doCompatibility("css", $this->args["main"]["filebase"], $this->args["main"]["css"]);
		}
		
		//	importando LESS de compatibilidade para todas as páginas
		if (is_array(@$this->args["main"]["less"])) {
			$this->doCompatibility("less", $this->args["main"]["filebase"], $this->args["main"]["less"]);
		}
		
		//	importando CSS de compatibilidade
		if (is_array(@$this->args["css"]) and @$this->args["css"] == TRUE) {
			$this->doCompatibility("css");
		}
		
		//	importando LESS de compatibilidade
		if (is_array(@$this->args["less"]) and @$this->args["less"] == TRUE) {
			$this->doCompatibility("less");
		}
		
		//	adicionando classes em JavaScript que eu criei
		if (is_array(@$this->args["js"])) {
			foreach (@$this->args["js"] AS $add) {
				if ($add == "forms") {
					echo("\r\n\t\t<script src='".$this->path."/resource/js/forms/forms.1.0.3.js$cache'></script>");
					echo("\r\n\t\t<link rel='stylesheet' href='".$this->path."/resource/js/forms/forms.1.0.3.css$cache' />");
				} else if ($add == "tooltip") {
					echo("\r\n\t\t<script src='".$this->path."/resource/js/tooltip/tooltip.js$cache'></script>");
					echo("\r\n\t\t<link rel='stylesheet' href='".$this->path."/resource/js/tooltip/tooltip.css$cache' />");
				} else if ($add == "jqueryui") {
					echo("\r\n\t\t<script src='".$this->path."/resource/js/jqueryui/jquery-ui-1.10.3.js$cache'></script>");
					echo("\r\n\t\t<link rel='stylesheet' href='".$this->path."/resource/js/jqueryui/jquery-ui-1.10.3.css$cache' />");
				} else {
					echo("\r\n\t\t<script src='".$this->path."/resource/js/classes/$add.class.js$cache'></script>");
				}
			}
		}
		
		//	importando o arquivo javascript espelhado
		if (@$this->args["js"]) {
			echo("\r\n\t\t<script src='".$this->getMirror("js")."$cache'></script>");
		}
		
		//	encerrando cabeçalho e iniciando body
		if (@$this->files["body"]) {
			require_once($_SERVER["DOCUMENT_ROOT"].$this->path.$this->files["body"]);
		}
		
		if (@$this->args["html"]) {
			//	raintpl
			$this->tpl = new RainTPL();
			
			//	caminhos do cache
			$html = $this->getMirror("cache");
			mksubdir($_SERVER["DOCUMENT_ROOT"].$html[0]);	//	criando subpastas
			$this->tpl->cache_dir = $_SERVER["DOCUMENT_ROOT"].$html[0];
			
			//	caminho dos htmls
			$html = $this->getMirror("html");
			$this->tpl->tpl_dir = $_SERVER["DOCUMENT_ROOT"].$html[0];
			
			//	passando todas as configurações para o template
			if (is_array(@$this->args["html"])) {
				foreach (@$this->args["html"] as $key => $tpl) {
					$this->tpl->assign($key, $tpl);
				}
			}
			$this->tpl->draw($html[1]);
		}
	}
	
	public function doCompatibility($type, $filebase = FALSE, $configs = FALSE) {
		$haystack = $_SERVER["HTTP_USER_AGENT"];
		$configs = ($configs) ? ($configs) : ($this->args[$type]);

		$cache = "";
		if (@$this->args["cache"] === FALSE) { $cache = ($type == "css") ? ("?_=".time()) : ("&_=".time()); }
		
		if (in_array("ie", $configs) and stristr($haystack, "MSIE")) {
			echo("\r\n\t\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "ie.")) : ($this->getMirror($type, "ie.")))."$cache' />");
		}
		
		if (in_array("ie6", $configs) and stristr($haystack, "MSIE 6")) {
			echo("\r\n\t\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "ie6.")) : ($this->getMirror($type, "ie6.")))."$cache' />");
		}
		
		if (in_array("ie7", $configs) and stristr($haystack, "MSIE 7")) {
			echo("\r\n\t\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "ie7.")) : ($this->getMirror($type, "ie7.")))."$cache' />");
		}
		
		if (in_array("ie8", $configs) and stristr($haystack, "MSIE 8")) {
			echo("\r\n\t\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "ie8.")) : ($this->getMirror($type, "ie8.")))."$cache' />");
		}
		
		if (in_array("ie9", $configs) and stristr($haystack, "MSIE 9")) {
			echo("\r\n\t\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "ie9.")) : ($this->getMirror($type, "ie9.")))."$cache' />");
		}
		
		if (in_array("ie10", $configs) and stristr($haystack, "MSIE 10")) {
			echo("\r\n\t\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "ie10.")) : ($this->getMirror($type, "ie10.")))."$cache' />");
		}
		
		if (in_array("firefox", $configs) and stristr($haystack, "firefox")) {
			echo("\r\n\t\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "firefox.")) : ($this->getMirror($type, "firefox.")))."$cache' />");
		}
		
		if (in_array("opera", $configs) and stristr($haystack, "opera") !== FALSE and stristr($haystack, "presto")) {
			echo("\r\n\t\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "opera.")) : ($this->getMirror($type, "opera.")))."$cache' />");
		}
		
		if (in_array("webkit", $configs) and stristr($haystack, "AppleWebKit")) {
			echo("\r\n\t\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "webkit.")) : ($this->getMirror($type, "webkit.")))."$cache' />");
		}
		
		if (in_array("chrome", $configs) and stristr($haystack, "AppleWebKit") and stristr($haystack, "Gecko) Chrome")) {
			echo("\r\n\t\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "chrome.")) : ($this->getMirror($type, "chrome.")))."$cache' />");
		}
		
		if (in_array("safari", $configs) and stristr($haystack, "AppleWebKit") and stristr($haystack, "Gecko) Version")) {
			echo("\r\n\t\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "safari.")) : ($this->getMirror($type, "safari.")))."$cache' />");
		}
	}
	
	protected function getMirror($type, $prefix = "") {
		switch($type) {
			case "html":
			case "cache":
				$path = explode("/", $_SERVER["PHP_SELF"]);
				$path[count($path) - 1] = "";
				$path = implode("/", $path);
				
				$doc = explode("/", $_SERVER["SCRIPT_NAME"]);
				$doc = explode(".", $doc[count($doc) - 1]);
				unset($doc[count($doc) - 1]);
				$doc = implode(".", $doc);

				return array($this->path."/mirror/$type$path/", $doc);
				break;
			case "css":
			case "js":
				return $this->path."/mirror/$type".$this->changeExtension($_SERVER["SCRIPT_NAME"], $type, $prefix);
				break;
			case "less":
				$file = $_SERVER["SCRIPT_NAME"];
				return $this->path."/resource/css/style.php?f=".base64_encode($this->changeExtension($this->path."/mirror/css".$_SERVER["SCRIPT_NAME"], "css", $prefix));
				break;
		}
	}
	
	private function changeExtension($file, $ext, $prefix = "") {
		$file = explode(".", $file);
		$file[count($file) - 1] = $ext;
		$file = implode(".", $file);
		
		$file = explode("/", $file);
		$file[count($file) - 1] = $prefix.$file[count($file) - 1];
		
		return implode("/", $file);
	}
	
	public function __destruct() {
		if ($this->files["footer"]) {
			require_once($_SERVER["DOCUMENT_ROOT"].$this->path.$this->files["footer"]);
		}
	}
}

?>
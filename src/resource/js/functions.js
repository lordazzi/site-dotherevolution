/**
	AJUSTES DE COMPATIBILIDADE
*/

//	em alguns browsers não existe indexOf para arrays
/* IE10 não suporta que seja ajustado os erros dos IEs antigos ¬¬

if (!Array.prototype.indexOf) {
	Array.prototype.indexOf = function(obj, start) {
		for (var i = (start || 0), j = this.length; i < j; i++) {
			if (this[i] === obj) { return i; }
		}
		return -1;
	}
}

//	varias incompatibilidades com a constante navigator
if (!window.navigator) { var navigator = {}; }
if (!window.navigator.userAgent) { navigator.userAgent = "Mozilla/4.0 (compatible; MSIE 6.0; ?)"; }
if (!window.navigator.language) {
	var lang = navigator.browserLanguage;
	if (lang) {
		lang = lang.split("-");
		lang[1] = lang[1].toUpperCase();
		lang.join("-");
		navigator.language = lang;
	} else {
		navigator.language = "";
	}
}

//	console não existe em alguns browsers
var console;
if (!console) {
	console = {};
	console.log = function(){};
	console.dir = function(){};
	console.error = function(){};
}*/

/**
	Constantes de compatibilidade
*/
var userAgent = (navigator.userAgent) ? (navigator.userAgent) : ("Mozilla/4.0 (compatible; MSIE 6.0; ?)");

var isIE = (userAgent.indexOf("MSIE") != -1);

var isIE6 = (userAgent.indexOf("MSIE 6") != -1);

var isIE7 = (userAgent.indexOf("MSIE 7") != -1);

var isIE8 = (userAgent.indexOf("MSIE 8") != -1);

var isIE9 = (userAgent.indexOf("MSIE 9") != -1);

var isIE10 = (userAgent.indexOf("MSIE 10") != -1);

var isFirefox = (userAgent.indexOf("Firefox") != -1);

var isWebKit = (userAgent.indexOf("AppleWebKit") != -1);

var isChrome = (userAgent.indexOf("Gecko) Chrome/") != -1 && userAgent.indexOf("AppleWebKit") != -1);

var isSafari = (userAgent.indexOf("Gecko) Version/") != -1 && userAgent.indexOf("AppleWebKit") != -1);

var isOpera = (userAgent.indexOf("Opera") != -1 && userAgent.indexOf("Presto") != -1);

/**
	FUNÇÕES
*/
var getCookie = (function(c_name) {
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++) {
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		if (x==c_name) {
			return unescape(y);
		}
	}
});

var get = (function(index){
	var query_string = document.location.href.split("#")[0].split("?")[1];
	if (index == null || index == "?") {
		return query_string;
	} else {
		if (query_string != null) {
			var vars = query_string.split("&");
			var gets = new Array();
			for (i = 0; i < vars.length; i++) {
				vars[i] = vars[i].replace("=", "<-------------->");
				vars[i] = vars[i].split("<-------------->");
				if (vars[i][0] == index) {
					return vars[i][1];
					break;
				}
			}
			return;
		}
	}
});

var playAudio = (function(srcbase, folder){
	folder = folder || "/resource/audio/"
	
	if (isIE && !(isIE9 || isIE10)) {
		$("<embed>", {
			"src": folder+srcbase+".mp3"
		}).css({
			visibility: "hidden",
			position: "absolute",
			bottom: 0,
			right: 0
		}).appendTo("body");
	} else {
		$ogg = $("<source>", {
			"src": folder+srcbase+".ogg",
			"type": "audio/ogg"
		});
		$mp3 = $("<source>", {
			"src": folder+srcbase+".mp3",
			"type": "audio/mpeg"
		});
		$wav = $("<source>", {
			"src": folder+srcbase+".wav",
			"type": "audio/wav"
		});
		
		$audio = $("<audio>", {
			autoplay: "autoplay"
		});
		$ogg.appendTo($audio);
		$mp3.appendTo($audio);
		$wav.appendTo($audio);
		$audio.css({
			visibility: "hidden",
			position: "absolute",
			bottom: 0,
			right: 0
		});
		$audio.appendTo("body");
	}
});

$(function(){
	/** PARA BROWSERS ANTIGOS */
	if (isIE && !isIE10) {
		$('<p class="chromeframe">' + 
			'Você está utilizando um navegador <strong>antigo</strong>.' + 
			'Por favor <a target="_blank" href="http://browsehappy.com/">' + 
			'atualize seu navegador</a> ou ' + 
			'<a target="_blank" href="http://www.google.com/chromeframe/?redirect=true">' + 
			'ative o Google Chrome Frame</a> para melhorar sua navegação.' + 
		'</p>').prependTo("header");
	}
	
	/** FUNÇÕES EXTRAS PRO JQUERY */
	$.fn.getCursor = function() {
		var el = $(this).get(0);
		var pos = 0;
		if('selectionStart' in el) {
		   pos = el.selectionStart;
		} else if('selection' in document) {
		   el.focus();
		   var Sel = document.selection.createRange();
		   var SelLength = document.selection.createRange().text.length;
		   Sel.moveStart('character', -el.value.length);
		   pos = Sel.text.length - SelLength;
		}
		return pos;
	}

	//seta o cursor dentro de uma caixa de texto
	$.fn.setCursor = function(pos) {
		var element = $(this).get(0);
		if (typeof(element.setSelectionRange) != "undefined") {
		   element.setSelectionRange(pos, pos);
		}
		else if (element.createTextRange) {
		   var breaks = element.value.slice(0, pos).match(/\n/g);
		   var endPoint = 0;
		   if (breaks instanceof Array) {
			   endPoint = -breaks.length;
		   }
		   var range = element.createTextRange();
		   range.collapse(true);
		   range.moveStart("character", pos);
		   range.moveEnd("character", endPoint);
		   range.select();
		}
	}
	
	/** RELATORIO DE VISITANTES */
	var lang = navigator.language;
	if (lang == undefined) {
		lang = navigator.browserLanguage;
		if (lang) {
			lang = lang.split("-");
			lang[1] = lang[1].toUpperCase();
			lang.join("-");
		} else {
			lang = "";
		}
	}
	
	$.ajax({
		type: "POST",
		url: "actions/register-visitor-first-ajax.php",
		data: {
			width: window.screen.width,
			height: window.screen.height,
			firstajax: new Date().getTime(),
			language: lang,
			browser: navigator.vendor,
			system: navigator.platform
		},
		success: function(retorno) {
			retorno = JSON.parse(retorno);
			if (retorno.success != false) {
				$.ajax({
					type: "POST",
					url: "actions/register-visitor-second-ajax.php",
					data: {
						secondajax: new Date().getTime()
					}
				});
			}
		}
	});
	
	/** SCRIPTS GERAIS */
	$("#submit-form").on("click", function(){
		$.ajax({
			url: "actions/do-login.php",
			type: "post",
			data: {
				"auth-login": $("#auth-login").val(),
				"auth-senha": $("#auth-senha").val()
			},
			success: function(json){
				json = JSON.parse(json);
				if (json.success == true) {
					if (Math.floor(Math.random() * 4) == 2) {
						playAudio("do_the_revolution");
						setTimeout(function(){
							window.location.href = "frases.php";
						}, 3500);
					} else {
						window.location.href = "frases.php";
					}
				} else {
					var $blockBackground = $("#main-block-background");
					$blockBackground.css({
						display: "block"
					});
					$blockBackground.animate({
						opacity: 1
					}, 500);
				}
			}
		});
	});
	
	$("#auth-senha").on("keypress", function(Event){
		if (Event.keyCode == 13) {
			$("#submit-form").trigger("click");
		}
	});
	
	$("#sair-do-sistema").on("click", function(){
		$.ajax({
			url: "actions/do-logoff.php",
			type: "post",
			success: function(json){
				window.location.href = window.location.href;
			}
		});
	});
	
	$("#ok-msg-login-e-senha").on("click", function(){
		$("#main-block-background").animate({
			"opacity": 0
		}, 500, function(){
			$(this).css({
				"display": "none"
			});
		});
	});
});
$(function(){
	$(".datepicker").datepicker({ autoSize: true });
	
	// menu que para abrir a frase
	$("#abrir-menu-da-frase").on("click", function(){
		var $blockBackground = $("#phrase-write-place");
		
		$blockBackground.css({
			display: "block"
		});
		
		$blockBackground.animate({
			opacity: 1
		}, 500);
	});
	
	$("#cancelar-frase").on("click", function(){
		$("#postar-minha-frase").val("");
		$("#phrase-write-place").animate({
			opacity: 0
		}, 500, function(){
			$(this).css({
				display: "none"
			});
		});
	});
	
	$("#ok-entendo-que-errei").on("click", function(){
		$("#error-msg-ao-tentar-enviar-frase").animate({
			"opacity": 0
		}, 500, function(){
			$(this).css({
				"display": "none"
			});
		});
	});
	
	$("#enviar-frase-escrita").on("click", function(){
		$.ajax({
			url: "actions/registra-frase.php",
			type: "post",
			data: {
				frase: $("#postar-minha-frase").val()
			},
			success: function(json){
				json = JSON.parse(json);
				if (json.success == true) {
					var data = new Date();
					$article = $("<article>", {
						style: "opacity: 0",
						class: "floating"
					});
					
					$span1 = $("<span>").addClass("author").text(json.autor+": ");
					$span2 = $("<span>").addClass("phrase").text(json.frase);
					$span3 = $("<span>").addClass("datetime").text(data.getDate()+"/"+(data.getMonth() + 1)+"/"+data.getFullYear()+" "+data.getHours()+":"+data.getMinutes());
					
					$span1.appendTo($article);
					$span2.appendTo($article);
					$span3.appendTo($article);
					
					$article.prependTo("#phrases");
					$article.animate({
						"opacity": 1
					}, 500);
					
					$("#cancelar-frase").trigger("click");
				} else {
					$("#your-error-msg-comes-here").text(json.msg);
					$("#error-msg-ao-tentar-enviar-frase").css({ "display": "block" });
					$("#error-msg-ao-tentar-enviar-frase").animate({
						"opacity": 1
					}, 500);
				}
			}
		});
	});
	
	var doLike = (function(){
		$this = $(this);
		$.ajax({
			url: "actions/do-like-phrase.php",
			type: "post",
			data: {
				id: $this.data("idcomentario")
			},
			success: function(json) {
				json = JSON.parse(json);
				if (json.success == true) {
					$this.attr("src", "/resource/ico/16/silver-unlike.png");
					$this.attr("class", "unlike");
					$this.off("click");
					$this.on("click", DoUnlike);
				}
			}
		});
	});
	
	var DoUnlike = (function(){
		$this = $(this);
		$.ajax({
			url: "actions/do-unlike-phrase.php",
			type: "post",
			data: {
				id: $this.data("idcomentario")
			},
			success: function(json) {
				json = JSON.parse(json);
				if (json.success == true) {
					$this.attr("src", "/resource/ico/16/silver-like.png");
					$this.attr("class", "like");
					$this.off("click");
					$this.on("click", doLike);
				}
			}
		});
	});
	
	$(".like").each(function(){
		$(this).on("click", doLike);
	});
	
	$(".unlike").each(function(){
		$(this).on("click", DoUnlike);
	});
});
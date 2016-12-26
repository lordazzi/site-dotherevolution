var f;
$(function(){
	f = new Forms({
		id: "formulario-de-cadastro",
		evt: "blur",
		action: function(el, status, msg, type){
			var id = el.attr("id")+"-tooltip";
			$("#"+id).remove();
			if (status) {
				if (el.data("important") == "important" && el.val() == "") {
					new tooltip({
						id: id,
						type: "warning",
						text: "É altamente recomendável o preenchimento deste campo",
						css: {
							left: el.offset().left + el.width() + 16,
							top: el.offset().top - 8
						}
					});
					el.css({
						"border": "1px solid #CD860F"
					});
				} else {
					el.css({
						"border": "1px solid #CCC"
					});
				}
			} else {
				var direction = el.data("tooltip-direction") || "right";
				var left = el.offset().left + el.width() + 16;
				if (direction == "left") {
					left = el.offset().left - 16;
				}
				
				new tooltip({
					id: id,
					type: "error",
					direction: direction,
					text: msg,
					css: {
						left: left,
						top: el.offset().top - 1
					}
				});

				el.css({
					"border": "1px solid #F00"
				});
			}
		},
		success: function(json) {
			json = JSON.parse(json);
			if (json.success == true) {
				playAudio("do_the_revolution");
				setTimeout(function(){
					window.location.href = "frases.php";
				}, 3500);
			}
		}
	});
});
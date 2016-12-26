var tooltip = (function(args){
	args = args || {};
	args.css = args.css ||  {};
	args.id = args.id || (new Date().getTime()).toString();
	args.direction = args.direction || "right";

	var $div = $("<div>", {
		id: args.id
	});
	$div.addClass("tooltip "+args.direction);
	
	var $arrow = $("<div>");
	$arrow.addClass("tooltip-arrow");
	
	var $inner = $("<div>");
	$inner.addClass("tooltip-inner");
	$inner.text(args.text);
	
	args.css.display = "block";
	args.css.position = "absolute";
	$div.css(args.css);
	
	var cssborder = {};
	if (args.type == "error") {
		cssborder["border-"+args.direction+"-color"] = "#390000";
		$arrow.css(cssborder);
		$inner.css({
			"background-color": "#390000"
		});
	} else if (args.type == "warning") {
		cssborder["border-"+args.direction+"-color"] = "#7E5208";
		$arrow.css(cssborder);
		$inner.css({
			"background-color": "#7E5208"
		});
	} else if (args.type == "accept") {
		cssborder["border-"+args.direction+"-color"] = "#024702";
		$arrow.css(cssborder);
		$inner.css({
			"background-color": "#024702"
		});
	}
	
	$arrow.appendTo($div);
	$inner.appendTo($div);
	$div.appendTo("body");
	
	if (args.direction == "left") {
		$div.css({
			"left": args.css.left - $div.width()
		});
	}
});
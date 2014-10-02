$(function(){
	var highlighter = "Unavailable";

	$('input[name=highlighter]').click(function(){
		highlighter = this.value;
		console.log(highlighter);
	});

	$('.can-work').change(function(){
		var day = this.value;
		var checked = this.checked;

		if (checked)
			$('.'+day).addClass('yellow').removeClass('red').text('Available');
		else $('.'+day).removeClass('yellow green').addClass('red').text('Unavailable');
	});

	$( "table" ).selectable({
		filter: ".selectable",
		selected: function(event, ui){
			switch(highlighter) {
				case "Unavailable": $(ui.selected).addClass('red').removeClass('yellow green').text(highlighter); break;
				case "Available": $(ui.selected).addClass('yellow').removeClass('red green').text(highlighter); break;
				case "Preferred": $(ui.selected).addClass('green').removeClass('red yellow').text(highlighter); break;
			}
		}
	});
});
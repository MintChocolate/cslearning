$(function(){
	var highlighter = "Unavailable";

	$('input[name=highlighter]').click(function(){
		highlighter = this.value;
	});

	$('.can-work').change(function(){
		var day = this.value;
		var checked = this.checked;

		if (checked)
			changeAvailability($('.'+day), "Available");
		else changeAvailability($('.'+day), "Unavailable");
	});

	$( "table" ).selectable({
		filter: ".selectable",
		selected: function(event, ui){
			changeAvailability($(ui.selected), highlighter);
		}
	});

	function changeAvailability (td, availability) {
		var values = {"Unavailable": 0, "Available": 1, "Preferred": 2}
		var new_value = values[availability];
		var colors = ['red', 'yellow', 'green'];
		var new_color = colors[new_value];
		colors.splice(new_value, new_value + 1);
		td.addClass(new_color).removeClass(colors.join(" "));
		td.find('.text').text(availability);
		td.find('input').val(new_value);
	}
});
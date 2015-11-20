$(function(){
	var ta_id = 0;
	var ta_name = "None";
	
	$('input[name=ta_select]').click(function(){
		ta_id = this.value;
		ta_name = $('label[for="' + this.id + '"]').html();
	});

	$( "table" ).selectable({
		filter: ".selectable",
		selected: function(event, ui){
			var td = $(ui.selected);
			var value = td.find('.text').text();
			var day = td.attr('data-day');
			chanceSchedule(td, ta_id, ta_name);
		}
	});

	function chanceSchedule (td, ta_id, ta_name) {
		ta_name == "None" ? td.find('label').html("") : td.find('label').html(ta_name);
		td.find('input').val(ta_id);	
	}
});
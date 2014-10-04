$(function(){
	var highlighter = "Unavailable";
	var undos = [];
	var redos = [];
	var changes = [];

	$('input[name=highlighter]').click(function(){
		highlighter = this.value;
	});

	$('.can-work').change(function(){
		var day = this.value;
		var checked = this.checked;

		$('td[data-day='+day+']').each(function(){
			var td = $(this);
			var value = td.find('.text').text();
			changes.push({td: td, was: value, current: checked?"Available":"Unavailable"});
		});

		if (checked)
			changeAvailability($('td[data-day='+day+']'), "Available");
		else changeAvailability($('td[data-day='+day+']'), "Unavailable");
		
		undos.push(changes);
		changes = [];
	});

	$( "table" ).selectable({
		filter: ".selectable",
		selected: function(event, ui){
			var td = $(ui.selected);
			var value = td.find('.text').text();
			var day = td.attr('data-day');
			if (highlighter !== "Unavailable")
				$('input[value='+day+']').prop("checked", true);
			changes.push({td: td, was: value, current: highlighter});
			changeAvailability(td, highlighter);
		},
		stop: function(event, ui){
			if(undos.length > 0)
				while(redos.length > 0){
					var redo = redos.pop();
					var undo = [];
					$(redo).each(function(){
						undo.push({td: this.td, was: this.current, current: this.was});
					});
					undos.push(redo);
					undos.push(undo);
				}
			else {
				redos = [];
			}
			undos.push(changes);
			changes = [];
		}

	});

	//Boolean to keep track of Ctrl or Command being pressed
	ctrlDown = false;
	shiftDown = false;

	//Define constants
	CTRL = 17;
	COMMAND = 91;
	SHIFT = 16;
	Z = 90;

	//Waiting for Ctrl+Z keyboard press
	$( window ).keydown(function(event) {
		//Check if Ctrl is pressed
		if (ctrlDown){
			if(event.which === SHIFT)
				shiftDown = true;
			else if(shiftDown){
				if (event.which === Z && redos.length > 0)
					redoChanges();
			}
			//Check if there were any changes and Ctrl+Z is pressed
			else if (event.which === Z && undos.length > 0)
				undoChanges();
		}
		//Check if Command, Ctrl or Shift were pressed
		else if (event.which === COMMAND || event.which === CTRL)
			ctrlDown = true;
		
	});

	$( window ).keyup(function(event) {
		if (event.which === COMMAND || event.which === CTRL)
			ctrlDown = false;
		else if(event.which === SHIFT)
			shiftDown = false;
	});

	function undoChanges(){
		//Get the last change made
		var changes = undos.pop();

		$(changes).each(function(index){
			changeAvailability(this.td, this.was);
		});

		redos.push(changes);
	}

	function redoChanges(){
		//Get the last change made
		var changes = redos.pop();
		
		$(changes).each(function(){
			changeAvailability(this.td, this.current);
		});

		undos.push(changes);
	}

	function changeAvailability (td, availability) {
		var values = {"Unavailable": 0, "Available": 1, "Preferred": 2}
		var new_value = values[availability];
		var colors = ['red', 'yellow', 'green'];
		var new_color = colors[new_value];
		colors.splice(new_value, new_value + 1);
		td.addClass(new_color).removeClass(colors.join(" "));
		td.find('.text').text(availability);
		td.find('input').val(new_value);
		var day = td.attr('data-day');
		if(new_value > 0)
			$('input[value='+day+']').prop('checked', true);
		else {
			var all_zeros = true;
			$('input[data-day='+day+']').each(function(){
				if (this.value !== "0"){
					all_zeros = false;
					$('input[value='+day+']').prop('checked', true);
					return false; //Quit each if we found at least one non-zero
				}
			});
			if (all_zeros)
				$('input[value='+day+']').prop('checked', false);
		}
	}
});
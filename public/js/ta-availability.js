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

		if (checked){
			$('.'+day).each(function(){
				var value = $(this).find('.text').text();
				changes.push({td: this.id, was: value});
			});
			undos.push(changes);
			changes = [];
			changeAvailability($('.'+day), "Available");
		}
		else {
			changeAvailability($('.'+day), "Unavailable");
		}
	});

	$( "table" ).selectable({
		filter: ".selectable",
		selected: function(event, ui){
			var value = $(ui.selected).find('.text').text();
			changes.push({td: $(ui.selected), was: value, current: highlighter});
			changeAvailability($(ui.selected), highlighter);
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
	}
});
$(function(){
	$('*[data-name]').click(function(){
		var button = $(this);
		var name = button.attr('data-name');
		return confirm('Are you sure you want to remove ' + name + "?");
	})

});
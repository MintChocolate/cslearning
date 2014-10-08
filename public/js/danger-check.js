$(function(){
	$('*[data-name]').click(function(evt){
		evt.preventDefault();
		var button = $(this);
		var action = button.attr('data-action');
		var name = button.attr('data-name');
		var form = this.form;
		bootbox.dialog({
			title: "Confirmation",
			message: 'Are you sure you want to ' + action + ' ' + name + "?",
			buttons: {
				danger: {
					label: action,
					className: "btn-danger",
					callback: function() {
						form.submit();
					}
				},
				cancel: {
					label: "cancel",
					className: "btn-default"
				}
			}
		});
	});

});
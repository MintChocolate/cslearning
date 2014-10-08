$(function(){
	$('.remind').click(function(evt){
		evt.preventDefault();

		var url = this.href;
		var link = $(this);

		$.ajax({
			url: url,
			type: "POST",
			success: function(data){
				link.text(data);
				link.removeClass('btn-info').addClass('btn-warning');
			}
		});
	});
});
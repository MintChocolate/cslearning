$(function(){
	$('#file').click(function(){
		$('input[name=file]').click();
	});

	$('input[name=file]').change(function(){
		$('#file').text(this.value.split("\\")[2]);
	});
});
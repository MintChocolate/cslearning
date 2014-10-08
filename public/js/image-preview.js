$(function(){
	var reader = new FileReader;
	reader.onload = function(e) {
		$("#image-preview").attr("src", e.target.result);
	}

	$('input[name=file]').change(function(){
		reader.readAsDataURL($(this).get(0).files[0]);
	});
});
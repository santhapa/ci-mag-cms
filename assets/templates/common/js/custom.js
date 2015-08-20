$(document).ready(function(){
	$('input.required, textarea.required, select.required').parent('div').prev('label').append('<em class="required" style="color:red;">*</em>');

	$(".validate").validate({
		errorClass: 'form-error',
  		wrapper: "span",
	});

});


function welcomeUserNoty(msg) {
  	var s = noty({
  		text: msg,
  		type: 'info',
      	dismissQueue: true,
  		layout: 'topRight',
  		theme: 'defaulTheme',
  		timeout: 4000,
  		closeWith:['button']
  	});
}
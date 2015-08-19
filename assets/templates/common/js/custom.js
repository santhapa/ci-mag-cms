$(document).ready(function(){
	$('input.required, textarea.required, select.required').parent('div').prev('label').append('<em class="required" style="color:red;">*</em>');

	$(".validate").validate({
		errorClass: 'form-error',
  		wrapper: "span",
	});

});

function tempAlert(msg, duration){
	var el = document.createElement("div");
	el.innerHTML = msg;
	setTimeout(function(){
		el.parentNode.removeChild(el);
	},duration);
	document.body.appendChild(el);
}
$(document).ready(function(){
// data
var step          = 1;
var message_len   = 36;
var message_input = $('#message').val();
// methods
function nextStepLabel() {
	$('.module_step_item.active').addClass('active_prev');
	//$('.module_step_item').removeClass('active');
	$('#step-label-' + step).addClass('active');
}

function nextStepTab() {
	$('.add-module-tab').removeClass('active');
	$('#step-' + step).addClass('active');
}

// events
$('#message').on('keyup', function(){
	var len      = $(this).val().length;
	var summ_len = message_len - len;
 
    if(summ_len >= 0) {
		message_input = $(this).val();
		$('#message-string-length').html(summ_len);
    } else {
    	$(this).val(message_input);	
    }
});

$('#addModuleNextStep').on('click', function(){
	step++;
	nextStepLabel();
	nextStepTab();
	return false;
});

$('.module_step_item').on('click', function(){
 	
 	if ($(this).hasClass('active') || $(this).hasClass('active_prev')) {
 		var id = $(this).data('id');
		step = id;
		$('.add-module-tab').removeClass('active');
		$('#step-' + id).addClass('active');	
 	}
	return false;
});

});
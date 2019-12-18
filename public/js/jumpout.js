$(document).on('click', '#moveToRedactor', function() {

	var href = $(this).attr('href');

    var data = {    
        'data' : {
        	'name' : $('#campaign_name').val(), 
            'queue' : $('#queue').val(), 
        },
        '_token' : $('meta[name="csrf-token"]').attr('content'),
    };

    $.ajax({
        type: "POST",
        url: '/api/jumpout/save-temp',
        data: data,
        success: function(result) {
        	if (result == 'updated') {
        		document.location.href = href;
        	} else {
        		alert('Storing temp data failed.');
        	}
        }
    });   


	console.log(href);

	return false;
});


$(document).on('click', 'a.link_back', function() {

    var id  = $('.module_step_item.active').data('id');
    var prev = (id > 1 ? id - 1: 0);

    if (prev == 0) {
        var domain_id = $('input[name="domain_id"]').val();
        document.location.href = '/admin/domains/' + domain_id + '/jumpout';
    }

    if (prev > 0) {
        $('.module_step_item').removeClass('active');
        $('.add-module-tab').removeClass('active');

        $('#step-label-' + prev).addClass('active');
        $('#step-' + prev).addClass('active');          
    }
 
    console.log(prev);

    return false;
})


$(document).on('click', 'a.link_next', function() {

	var id = $('.module_step_item.active').data('id');
	var next = (id < 3 ? id + 1: 3);

	var isValid = validateStep(id);

	console.log(isValid);

	if (isValid) {

		$('.module_step_item').removeClass('active');
		$('.add-module-tab').removeClass('active');

		$('#step-label-' + next).addClass('active');
		$('#step-' + next).addClass('active');		
	}

	return false;
});


function validateStep(step) {

	if (step == 1) {
		return checkFirstStep();
	}

	if (step == 2) {
		return checkSecondStep();
	}

    if (step == 3) {
        return checkThirdStep();
    }

	return false;
}
 
function checkFirstStep() {
	var val   = $('#campaign_name').val().trim();
    var queue = $('#queue').val().trim();

	if (val.length > 0 && queue.length > 0) {
		$('#campaign_name').removeClass('error');
        $('#queue').removeClass('error');
		return true;
	} else {
        if (val.length < 1) { $('#campaign_name').addClass('error'); }
        if (queue.length < 1) { $('#queue').addClass('error'); }
		return false;
	}	
}

function checkSecondStep() {

    if ($('#moveToRedactor').data('type') == 'edit') {
        $('.jump_out_block').removeClass('error');
        return true;
    } else {
        $('.jump_out_block').addClass('error');
        return false;
    }
}

function checkThirdStep() {

    var isValid = validateStepThree();

    if (isValid) {  

        var display = '';

        $('ul#show-list li').each(function(i) {
            display = display + $(this).find('span').text() + ';';
        });

        var data = {    
            'data' : {
                'name' : $('#campaign_name').val(),
                'priority' : $('#queue').val(),
                'domain_id' : $('input[name="domain_id"]').val(),     
                'display' : display,
                'show_main' : $('input[name="show_main"]:checked').val(),
                'show_all' : $('input[name="show_all"]:checked').val(),
            },
            '_token' : $('meta[name="csrf-token"]').attr('content'),
        };

        var element =  document.getElementById("module_id");
        
        if (typeof(element) != 'undefined' && element != null)
        {
            data.data.type      = 'edit';
            data.data.module_id =  document.getElementById("module_id").value;
        } else {
            data.data.type = 'create';   
        }

        $.ajax({
            type: "POST",
            url: '/api/jumpout/store',
            data: data,
            success: function(result) {
                if (result == 'updated') {
                    document.location.href = '/admin/domains/' + data.data.domain_id+  '/jumpout/';
                } else {
                    alert('Storing temp data failed.');
                }
            }
        });   

    }

    console.log('second step');
    return false;
}

function validateStepThree() {

    var s_main = $('input[name="show_main"]:checked').val();
    var s_all  = $('input[name="show_all"]:checked').val();

    if (s_main == 'yes' || s_all == 'yes') {
        return true;
    } else {
        $('#show-list li').length > 0 ? $('#where_show_notifications').removeClass('error') : $('#where_show_notifications').addClass('error');     
        return ($('#show-list li').length > 0 ? true : false);  
    }
}
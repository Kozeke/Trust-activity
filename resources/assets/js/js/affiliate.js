$(document).ready(function(){

    $(document).on('click', '#email-to-friends', function(){
 
        var data = {    
            'emails' : $('input[name="send-to-friends"]').val(),
            '_token' : $('meta[name="csrf-token"]').attr('content'),
        };

        $('input[name="send-to-friends"]').val('');

        $.ajax({
            type: "POST",
            url: '/admin/discount/emails',
            data: data,
            success: function(result) {

                if (result == 'true') {

                    document.getElementById('alert-emails').className += ' show';
                    setTimeout(function(){
                        document.getElementById('alert-emails').className = 'alert-notification';
                    }, 5000);

                    $('input[name="send-to-friends"]').css("box-shadow", "0 0 4px rgba(0, 0, 0, 0.1)");
                } else {
                    $('input[name="send-to-friends"]').css("box-shadow", "0 0 4px rgba(255, 0, 0, 1)");
                }
            }
        });

        return false;
    });

    $(document).on('click', '#partner-request', function(){
        console.log($(this).data('message'));
        var message = $(this).data('message');
        var data    = {    
            '_token' : $('meta[name="csrf-token"]').attr('content'),
        };

        $.ajax({
            type: "POST",
            url: '/admin/partners/request',
            data: data,
            success: function(result) {
 
                if (result == 'true') {
                    $('#partner-request').after('<p id="partner-warning" style="display: none;">' + message + '</p>');
                    $('#partner-request').fadeOut(function(){
                        $('#partner-request').remove();
                        $('#partner-warning').fadeIn();
                    }); 
                } else if (result == 'false') {
                    alert('Error. Try again.');
                }
            }
        });
    });

    $(document).on('click', '#copy_code, #copy_link', function(){

        const el = document.createElement('textarea');  // Create a <textarea> element
        if ($(this).attr('id') == 'copy_link') {
            var src  = $(this).prev().val();
        } else {
            var src  = $(this).prev().val();
        }

        el.value = src; // Set its value to the string that you want copied
        el.setAttribute('readonly', '');                // Make it readonly to be tamper-proof
        el.style.position = 'absolute';                 
        el.style.left = '-9999px';                      // Move outside the screen to make it invisible
        document.body.appendChild(el);                  // Append the <textarea> element to the HTML document
        const selected =            
        document.getSelection().rangeCount > 0        // Check if there is any content selected previously
          ? document.getSelection().getRangeAt(0)     // Store selection if found
          : false;                                    // Mark as false to know no selection existed before
        el.select();                                    // Select the <textarea> content
        document.execCommand('copy');                   // Copy - only works as a result of a user action (e.g. click events)
        document.body.removeChild(el);                  // Remove the <textarea> element
        if (selected) {                                 // If a selection existed before copying
        document.getSelection().removeAllRanges();    // Unselect everything on the HTML document
        document.getSelection().addRange(selected);   // Restore the original selection
        }

        document.getElementById('alert-notification').className += ' show';
        setTimeout(function(){
            document.getElementById('alert-notification').className = 'alert-notification';
        }, 3000);

    });

	$(document).on('click', '#transfer-to-balance', function(){

		var data = {	
			'summ' : $('#operation-summ').val(),
			'_token' : $('meta[name="csrf-token"]').attr('content'),
		};

		$.ajax({
            type: "POST",
            url: '/admin/discount/transfer',
            data: data,
            success: function(result) {

            	if (result == 'true') {

			        document.getElementById('alert-transferred').className += ' show';
			        setTimeout(function(){
			            document.getElementById('alert-transferred').className = 'alert-notification';
			        }, 5000);

            		var curr_balance = $('.sidebar_user_balance')[0].children[1].innerHTML;
					curr_balance    = curr_balance.replace('$ ', '');
					var new_balance = parseInt(curr_balance) + parseInt($('#operation-summ').val());
					$('.sidebar_user_balance')[0].children[1].innerHTML = '$ ' + new_balance;
  
            		var curr_ref = $('#total_referral_money').html();
					curr_ref     = curr_ref.replace('$', '');
					var new_ref  = parseInt(curr_ref) - parseInt($('#operation-summ').val());
            		$('#total_referral_money').html('$' + new_ref);
 	          		$('.count_transfer_money').css("box-shadow", "0 0 4px rgba(0, 0, 0, 0.1)");

                    var history_elem = '<div class="payment_block_list_item">' +
                            '<p class="payment_day payment_left">Now</p>' +
                            '<p class="payment_amount payment_center">$ '+ $('#operation-summ').val() +'</p>' +
                            '<p class="payment_method payment_center">Balance</p>' +
                            '<p class="payment_status payment_right payment_success">Accepted</p>' +
                        '</div>';

                    $('.payment_block_list').append(history_elem);
                    $('#operation-summ').val('');

            	} else {
            		$('.count_transfer_money').css("box-shadow", "0 0 4px rgba(255, 0, 0, 1)");
            	}
            }
        });

		return false;
	});

	$(document).on('click', '#withdraw-to-card', function(){

		var data = {	
			'summ' : $('#operation-summ').val(),
			'_token' : $('meta[name="csrf-token"]').attr('content'),
		};

		$.ajax({
            type: "POST",
            url: '/admin/discount/withdraw',
            data: data,
            success: function(result) {

            	if (result == 'true') {

			        document.getElementById('alert-withdraw').className += ' show';
			        setTimeout(function(){
			            document.getElementById('alert-withdraw').className = 'alert-notification';
			        }, 5000);

            		var curr_ref = $('#total_referral_money').html();
					curr_ref     = curr_ref.replace('$', '');
					var new_ref  = parseInt(curr_ref) - parseInt($('#operation-summ').val());
            		$('#total_referral_money').html('$' + new_ref);

            		var curr_wdraw = $('#withdraw_money').html();
					curr_wdraw     = curr_wdraw.replace('$', '');
					var new_wdraw  = parseInt(curr_wdraw) + parseInt($('#operation-summ').val());
            		$('#withdraw_money').html('$' + new_wdraw);

 	          		$('.count_transfer_money').css("box-shadow", "0 0 4px rgba(0, 0, 0, 0.1)");
                    $('#operation-summ').val('');
            	} else {
            		$('.count_transfer_money').css("box-shadow", "0 0 4px rgba(255, 0, 0, 1)");
            	}

            }
        });

		return false;
	});



});
$(document).ready(function(){

    /*$(document).ready(function() {
        $('.notification_tabs_item:not(.active)').mouseenter(function() {
            $(this).find('.inactive_block').fadeIn('fast');
        });
        $('.notification_tabs_item:not(.active)').mouseleave(function() {
            $(this).find('.inactive_block').fadeOut('fast');
        });
    });*/
 
	///////// удаление в общем списке 
	$(document).on('click', '.domain_list_delete', function(){
		if ($(this).parent().parent().find('.domain_deleted').length == 0) {
			var data = {	
				'id' : $(this).data('id'),
				'_token' : $('meta[name="csrf-token"]').attr('content'),
			};
			$.ajax({
	            type: "POST",
	            url: '/api/domains/delete',
	            data: data,
	            success: function(result) {
	            }
	        });
			$(this).parent().parent().append('<div class="domain_deleted">Domain deleted. <a href="#" class="undelete_domain" data-id="' + data.id + '">Undo</a><br/>' +
											 '<p>The domain will be fully deleted from our database after 23:59 hours.' + 
											 'Please, press "Undo" if you want to restore this domain or all data will be deleted permanently.</p></div>');

			$(this).parent().parent().find('.domain_deleted').fadeIn('fast', function(){ });
		}
 
		return false;
	});
// восстановить в общем списке
	$(document).on('click', '.undelete_domain', function(){
		var data = {	
			'id' : $(this).data('id'),
			'_token' : $('meta[name="csrf-token"]').attr('content'),
		};
		$.ajax({
            type: "POST",
            url: '/api/domains/delete',
            data: data,
            success: function(result) {
            }
        });

		$(this).parent().fadeOut('fast', function(){
			$(this).remove();
		});
	});
// восстановить в детальной домена
	$(document).on('click', '#domain-page-undelete', function(){

		var data = {	
			'id' : $(this).data('id'),
			'_token' : $('meta[name="csrf-token"]').attr('content'),
		};
		$.ajax({
            type: "POST",
            url: '/api/domains/delete',
            data: data,
            success: function(result) {
            }
        });

		$('.deleted_blackout').fadeOut('fast', function(){});
		return false;
	});
// удалить в детальной домена
	$(document).on('click', '.domain_delete', function(){

		var data = {	
			'id' : $(this).data('id'),
			'_token' : $('meta[name="csrf-token"]').attr('content'),
		};

		$.ajax({
            type: "POST",
            url: '/api/domains/delete',
            data: data,
            success: function(result) {
            }
        });
        
		if ($('.deleted_blackout').length == 0) {
	        $('.admin_main').prepend('<div class="deleted_blackout" style="display: none;">' +
	        	'<div class="c-notification_disabled_fon">' +
	        	'<div class="icon_disabled_fon"></div>' +
	        	'<div class="title_disabled_fon">Domain deleted!</div>' +
	        	'<div class="text_disabled_fon">The domain will be fully deleted from <br>our database after 23:59 hours.</div>' +
	        	'<div class="link_disabled_fon">' +
	        	'<a href="#" id="domain-page-undelete" data-id="' + $(this).data('id') +'"><span>Restore</span><span></span></a></div></div>' +
	        	'</div>');
       	}

		$('.deleted_blackout').fadeIn('fast', function(){});
        $('.popup_settings').removeClass('active');
        $('.popup_settings_fon').fadeOut();
		
		return false;
	});



	//domain_delete



	$(document).on('click', '.domain_edit', function() {
		var name = $('.admin_title.domain_settings_title h1').html();
		$('.admin_title.domain_settings_title h1').after('<input type="text" name="new_h1" value="' + name + '" class="edit_domain-name" />');
		$('.admin_title.domain_settings_title h1').fadeOut(300, function(){
			$('.edit_domain-name').fadeIn(300);			
		});
 		$('.domain_settings .domain_edit').fadeOut(300, function(){});
 		$('.domain_settings .domain_delete').fadeOut(300, function(){
 			$('.domain_settings .domain_save').fadeIn('fast'); 			
 		});
	});

	$(document).on('click', '.domain_save', function() {
		var name = $('.edit_domain-name').val();
		$('.admin_title.domain_settings_title h1').html(name);
		$('.admin_title.domain_title h1').html(name);
		$('.domain_link.active span:nth-child(2)').html(name);

		var data = {	
			'name' : name,
			'_token' : $('meta[name="csrf-token"]').attr('content'),
		};

		$.ajax({
            type: "POST",
            url: '/api/domains/notification/rename',
            data: data,
            success: function(result) {
            }
        });

	  	$('.domain_settings .domain_save').fadeOut(300, function(){
 			$('.domain_settings .domain_edit').fadeIn(300);
 			$('.domain_settings .domain_delete').fadeIn(300);

			return false;
 		});

 		$('.edit_domain-name').fadeOut(300, function(){
 			$('.admin_title.domain_settings_title h1').fadeIn(300);
 			$('.edit_domain-name').remove();

 			return false;
 		});		

	});

	$(document).on('click', '.api_link', function(){
		$('.api_popup_fon').fadeIn(300);
		$('.api_popup').fadeIn(300);

		return false;
	});

	$(document).on('click', '.api_popup_fon', function(){
		$('.api_popup_fon').fadeOut(300);
		$('.api_popup').fadeOut(300);

		return false;
	});

	$(document).on('click', '#send-to-developer-1, #send-to-developer-2', function(){
		var developerLink   = $('#foo').html(); 
		var script          = '<script type="text/javascript" src="'+ $('#clipboard-src').html() +'"></script>';
		var encoded_subject = encodeURIComponent("Trust Activity plugin installation");
		var encoded_body    = encodeURIComponent("Hi there,\n\nPlease add Trust Activity script to our website:\n\n" +
		 script + "\n\nLet me know once you are done.\n\nThanks in advance!");
		var mailto_link     = "mailto:?subject=" + encoded_subject + "&body=" + encoded_body;
		window.open(mailto_link, '_blank');
	});

   $(document).on('click', '#api_link', function(){

        const el = document.createElement('textarea');  // Create a <textarea> element
        var src  = $(this).prev().val();

        el.value = src; // Set its value to the string that you want copied
        //el.setAttribute('readonly', '');                // Make it readonly to be tamper-proof
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

		$('.api_popup_fon').fadeOut(300);
		$('.api_popup').fadeOut(300);

        document.getElementById('alert-notification').className += ' show';
        setTimeout(function(){
            document.getElementById('alert-notification').className = 'alert-notification';
        }, 3000);
    });

   $(document).on('click', '.w-platform-item', function(){

   		var type = $(this).data('type');
		$('.w-platform-item').removeClass('active');
   		if (!$(this).hasClass('active')) {
 			$(this).addClass('active');		
   		}  
 
   		if (type != 'other') {
   			$('#other').hide();
   			$('#cms').show();
   		} else {
   			$('#cms').hide();
   			$('#other').show();			
   		}
   });




});
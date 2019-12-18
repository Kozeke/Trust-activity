
$(document).ready(function(){

	(function() {
	    var AddnewModule = {
	    	// class data
	    	url_num : 1,
			step : 1,
			message_len : 36,
			message_input : $('#message').val(),
			edited: 0,
			// init AKA __construct
	        init: function() {
	        	this.bindEventHandlers();

				if ($('input[name="module_id"]').length > 0) {
					this.startTrackingChanges();
				}

	            //this.bindEventHandlers();
	            $(document).on('click', 'a.delete_url_item', function(){ return AddnewModule.captureRemoveURL($(this)); } );
	        },
	        startTrackingChanges: function() {
	        	var list = $('.add-module-tab input, .add-module-tab select');
	        	var watch_items = '';
	        	$.each(list, function(index, item) {
	        		var id = $(item).attr('id');
	        		watch_items += '#' + id + ', ';
	        	});

				var watch_items = watch_items.substring(0, watch_items.length - 2);
				var that = this;

 				$(watch_items).on('input', function() {

 					var edited = $(this).hasClass('edited');
	 			 	var tag    = $(this).prop('tagName');
 					var name   = $(this).attr('name');
	
 					if($(this).data('value') != undefined && $(this).data('value') != $(this).val() && !edited) {

 						that.edited++;
 						$(tag + '[name="' + name + '"]').addClass('edited');
 						$('#alert-notification').removeClass('show');
 						$('.module_example_block.edit-info-block').addClass('alert');
 						$('.module_example_block.edit-info-block span').html($('.module_example_block.edit-info-block span').data('change'));
 					} else if($(this).data('value') == $(this).val() && that.edited > 1 && edited) {
 
 						that.edited--;
 						$(tag + '[name="' + name + '"]').removeClass('edited');
 					} else if($(this).data('value') == $(this).val() && that.edited == 1 && edited) {

 						that.edited--;
 						$(tag + '[name="' + name + '"]').removeClass('edited');
 						$('.module_example_block.edit-info-block').removeClass('alert');
 						$('.module_example_block.edit-info-block span').html($('.module_example_block.edit-info-block span').data('default'));		
 					} else if($(this).data('value') != $(this).val() && edited) {
 						//console.log('bug');
 					} else {
 						//console.log('if('+$(this).data('value') +'!='+ $(this).val() +'&&'+ edited);
 						//console.log('wtf');
 					}

 					console.log('edited' + that.edited);
				});
	        },
	        // change tab by click on step icon (only if passed)
			changeTab: function(element) {
			 	if (element.hasClass('active') || element.hasClass('active_prev')) {
					if (this.step == 4) { this.hideFinishButton(); }
			 		var id    = element.data('id');
					this.step = id;
					$('.add-module-tab').removeClass('active');
					$('#step-' + id).addClass('active');	
					if (id == 4) { this.showFinishButton(); }
			 	}
				return false;
			},
			// show tab by current step (should be next)
			nextStepTab: function() {
				$('.add-module-tab').removeClass('active');
				$('#step-' + this.step).addClass('active');
			},
			// change active step icon (check as passed and make active next one)
			nextStepLabel: function() {
				$('.module_step_item.active').addClass('active_prev');
				if (this.step == 4) { this.showFinishButton(); }
				$('#step-label-' + this.step).addClass('active');
			},
			backStepLabel: function() {
				for (var i = 4; this.step < i; i--) {
					$('#step-label-' + i).removeClass('active');
					$('#step-label-' + i).removeClass('active_prev');			
				}
			},
			hideBack: function() {
				$('#addModuleBackStep').removeClass('active');
			},
			showBack: function() {
				$('#addModuleBackStep').addClass('active');
			},
			backStep: function() {
				if (this.step > 1) {
					if (this.step == 4) { this.hideFinishButton(); }
					if (this.step == 1) { this.hideBack(); }
					this.step--;
					this.backStepLabel();
					this.nextStepTab();					
				} else if (this.step == 1) {
					return true;
				}

				return false;
			},
			// next step main controller
			nextStep: function() {
				if (this.step === 1) {
					var isValid = this.validateStepOne();
					if (isValid) { this.showBack(); }
				} else if(this.step === 2) {
					var isValid = this.validateStepTwo();
				} else if(this.step === 3) {
					var isValid = this.validateStepThree();
					if (isValid) { this.showFinishButton(); }
				}

				if (isValid) {
					this.step++;
					this.nextStepLabel();
					this.nextStepTab();					
				}	

				return false;
			},
			showFinishButton: function() {
				$('#addModuleNextStep').parent().hide();
				$('#finishModuleStep').parent().addClass('active');
			},
			hideFinishButton: function() {
				$('#addModuleNextStep').parent().show();
				$('#finishModuleStep').parent().removeClass('active');		
			},		
			validateStepThree: function() {

				var s_main = $('input[name="show_main"]:checked').val();
				var s_all  = $('input[name="show_all"]:checked').val();

				if (s_main == 'yes' || s_all == 'yes') {
					return true;
				} else {
					$('#show-list li').length > 0 ? $('#where_show_notifications').removeClass('error') : $('#where_show_notifications').addClass('error'); 	
					return ($('#show-list li').length > 0 ? true : false);	
				}
			},
			validateStepTwo: function() {
				$('#capture-list li').length > 0 ? this.addSuccess($('#url_name')) : this.addError($('#url_name')); 	
				return ($('#capture-list li').length > 0 ? true : false);
			}, 
			//
			validateStepOne: function() {
 
				var anonymous   = $('input[name="show_conversions"]:checked').val();
				var fake_locale = $('#time-from').val() + ';' + $('select[name="time-from-type"]').val() + ';' + $('#time-to').val() + ';' + $('select[name="time-to-type"]').val();

				var error = 0;
				error += this.checkInput($('#campaign_name'), 'string');
				error += this.checkInput($('#message'), 'string');
				error += this.checkInput($('input[name="conversions"]'), 'int');
				error += this.checkInput($('input[name="days"]'), 'int');
				error += (this.checkFakeTime(fake_locale) ? 0 : 1);
 	
				return (error == 0 ? true : false);
			},

			checkInput: function(element, type) {

				switch (type) {
				  case 'string':
					var isValid = (element.val().trim() == '' ? 1 : 0 );
					isValid == 1 ? this.addError(element) : this.addSuccess(element); 
				    break;
				  case 'int':
					var isValid = (Number.isInteger(parseInt(element.val().trim())) == '' ? 1 : 0 );
					isValid == 1 ? element.addClass('error') : element.removeClass('error'); 		
				    break;
				  default:
					var isValid = (element.val().trim() == '' ? 1 : 0 );
					isValid == 1 ? this.addError(element) : this.addSuccess(element); 
				}
 
				return isValid;
			},
			addError: function(element) {
				element.parent().find('.success_icon').remove();
				element.addClass('error');
				//if (element.parent().find('.error_icon').length == 0) {
					element.after('<span class="error_icon"></span>');
					element.after('<p class="error_text">Invalid ' + element.attr('name') + '</p>');
				//}
			},
			addSuccess: function(element) {
				element.parent().find('.error_icon').remove();
				element.parent().find('.error_text').remove();
				element.removeClass('error');

				//if (!element.parent().find('.success_icon')) {
					element.after('<span class="success_icon"></span>');
				//}
			},
			showMain: function() {
				//console.log('showMain');
				var status = $('input[name="show_main"]:checked').val();
				if (status == 'yes') {
					//this.edited--;
 
					if ($('#all_no').data('value') == $('#all_no').val()) {
						this.edited--;
						if(this.edited == 0) { $('.module_example_block.edit-info-block').removeClass('alert'); }	
					} else {
						console.log('show main');
						this.edited++;	
					}

					$('#all_no').prop('checked', true);
				}

				this.disableWhereShowInput();
			},
			showAll: function() {
				//console.log('showAll');
				var status = $('input[name="show_all"]:checked').val();
				if (status == 'yes') {
					//this.edited--;
					if ($('#main_no').data('value') == $('#main_no').val()) {
						this.edited--;
						if(this.edited == 0) { $('.module_example_block.edit-info-block').removeClass('alert'); }	
					} else {
						console.log('show all');
						this.edited++;	
					}

					$('#main_no').prop('checked', true);
				}

				this.disableWhereShowInput();
			},
			disableWhereShowInput: function() {

				var s_main = $('input[name="show_main"]:checked').val();
				var s_all  = $('input[name="show_all"]:checked').val();

				if (s_main == 'yes' || s_all == 'yes') {
					$('.module_add_row.add_url_row').addClass('disabled');
				} else {
					$('.module_add_row.add_url_row').removeClass('disabled');
				}
			},
			countMessageFieldLength: function(element) {
				var len      = element.val().length;
				var summ_len = this.message_len - len;
			 
			    if(summ_len >= 0) {
					this.message_input = element.val();
					$('#message-string-length').html(summ_len);
					if (len == 0) {
						$('#module_example_mess').html($('#module_example_mess').data('placeholder'));	
					} else {
						$('#module_example_mess').html(element.val());						
					}
			    } else {
			    	element.val(this.message_input);	
			    }
			},
			CheckIsValidDomain: function(domain) { 
			    var re = new RegExp(/^((?:(?:(?:\w[\.\-\+]?)*)\w)+)((?:(?:(?:\w[\.\-\+]?){0,62})\w)+)\.(\w{2,6})$/); 
			    return domain.match(re);
			},
			addFakeCity: function() { 
			   
			   var city = $('#fake_city').val();

			   if (city.length > 0) {
				   $('#fakecity-list').append('<li class="added_url_item"><span>' + city + '</span><a href="#" class="delete_url_item"></a></li>');
				   $('#fake_city').val('');
				   this.checkBubbles('#fakecity-list');
			   }

			   return false;
			},
			captureAddURL: function(input, list) {
				var value = input.val();

				if (value !== '') {

					//value     = value.replace(/(^\w+:|^)\/\//, '');
					//value     = value.replace('www.', '');
					var data = {	
						'url' : value,
						'_token' : $('meta[name="csrf-token"]').attr('content'),
						'domain_id' : $('input[name="domain_id"]').val()
					};

					var vm = this;

					$.ajax({
		                type: "POST",
		                url: '/api/domains/validate',
		                data: data,
		                success: function(result) {

		                	if (result !== 'false') {
		                		$(list).append('<li class="added_url_item"><span>' + result + '</span><a href="#" class="delete_url_item"></a></li>');
		                		var value = input.val('');
		                		vm.addSuccess(input)
		                	} else {
		                		vm.addError(input)
		                	}

		                	vm.checkBubbles(list);
		                }
		            });
					//$(list).append('<li class="added_url_item"><span>' + value + '</span><a href="#" class="delete_url_item"></a></li>');
					//var value = input.val('');
				}

 

	 
				return false;
			},
			checkBubbles: function(list) {
				// check if changed
				if (list && $('input[name="module_id"]').length > 0) {

					var values  = $(list).data('value');
					var explode = ((values.length > 0) ? values.split(';') : '');
					var items   = $(list + ' > li');

					if (explode.length == items.length) {

						$.each(items, function(index, item) {
			        		var item = $(item).find('span').html();
			        		values = values.replace(item, '');

			        	})

			        	values = values.replace(';', '');

			        	if(values == '') {
							this.edited--;
							if (this.edited == 0) {
								$('.module_example_block.edit-info-block').removeClass('alert');
							}
			        	}

					} else if (explode.length > items.length || explode.length < items.length) {
 
						if (this.edited == 0) {
							$('.module_example_block.edit-info-block').addClass('alert');
						}

						this.edited++;
					}
				}
			},
			captureRemoveURL: function(button) {	
				var id = button.parent().parent().attr('id');
				button.parent().remove();
				this.checkBubbles('#' + id);

				return false;
			},
			updateSettings: function() {

				var hide_notifications = $('input[name="hide_notifications"]:checked').val();
				var show_on_top        = $('input[name="show_on_top"]:checked').val();
				var position           = $('input[name="position"]:checked').val();
				var spacing_between    = $('input[name="spacing_between"]').val();
				var viewing_this_page  = $('input[name="viewing_this_page"]:checked').val();
				var domain_id          = $('input[name="domain_id"]').val();
				var locale             = $('select[name="locale"] option:selected').val();		

				var data = {
					'locale': locale,
					'hide_notifications': hide_notifications,
					'show_on_top': show_on_top,
					'position': position,
					'spacing_between': spacing_between,
					'viewing_this_page': viewing_this_page,
					'_token' : $('meta[name="csrf-token"]').attr('content'),
					'domain_id' : domain_id,
				}

				$.ajax({
	                type: "POST",
	                url: '/api/domains/notification/settings/update',
	                data: data,
	                success: function(result) {
	                	window.location.replace("/admin/domains/" + domain_id);
	                }
	            });
				return false;
			},
			getBase64: function(file, onLoadCallback) {
			    return new Promise(function(resolve, reject) {
			        var reader = new FileReader();
			        reader.onload = function() { resolve(reader.result); };
			        reader.onerror = reject;
			        reader.readAsDataURL(file);
			    });
			},
			readURL: function(input) {
			  if (input.files && input.files[0]) {
			    var reader = new FileReader();
			    reader.onload = function(e) {
					var test = $('#custom-image');
					$('#custom-image').attr('src', e.target.result);
			    }

			    reader.readAsDataURL(input.files[0]);
			  }
			},
			addModule: function(item) {

				var current_item = item.attr('id');
				var capture   = '';
				var display   = '';
				var fake_city = '';
				var post_url  = '/api/domains/notification/add';

				$('ul#capture-list li').each(function(i) {
					capture = capture + $(this).find('span').text() + ';';
				});

				$('ul#show-list li').each(function(i) {
					display = display + $(this).find('span').text() + ';';
				});

				$('ul#fakecity-list li').each(function(i) {
					fake_city = fake_city + $(this).find('span').text() + ';';
				});

				var campaign_name      = $('input[name="name"]').val();
				var message            = $('input[name="message"]').val();
				var conversions        = $('input[name="conversions"]').val();
				var days               = $('input[name="days"]').val();
				var show_conversions   = $('input[name="show_conversions"]:checked').val();
				var send_to_url        = $('input[name="send_to_url"]').val();
				var open_new           = $('input[name="open_new"]:checked').val();
 				var domain_id          = $('input[name="domain_id"]').val();
 				var translate_someone  = $('#translate-someone').val();
 				var translate_from     = $('#translate-from').val();		
 				var locale             = $( "#locale" ).val();
 
 				var fake               = $('input[name="fake"]:checked').val();
 				//var fake_city          = $( "#fake_city" ).val();
 				var fake_locale        = $('#time-from').val() + ';' + $('select[name="time-from-type"]').val() + ';' + $('#time-to').val() + ';' + $('select[name="time-to-type"]').val();
 
				var show_main = $('input[name="show_main"]:checked').val();
				var show_all  = $('input[name="show_all"]:checked').val();

				var data = {
					'campaign_name': campaign_name,
					'message': message,
					'conversions': conversions,
					'days': days,
					'show_conversions': show_conversions,
					'capture': capture,
					'display': display,
					'send_to_url': send_to_url,
					'open_new': open_new,
					'_token' : $('meta[name="csrf-token"]').attr('content')	,
					'domain_id' : domain_id,
					'translate_someone' : translate_someone,
					'translate_from' : translate_from,	
					'locale' : locale,
					'fake' : fake,
					'fake_city' : fake_city,
					'fake_locale' : fake_locale,
					'show_main' : show_main,
					'show_all' : show_all,		
					'photo' : null		
				};
 
				if ($('input[name="module_id"]').length > 0) {
					data.module_id = $('input[name="module_id"]').val();
					var post_url = '/api/domains/notification/update';
				}

				var image = $('.icon-elem.active').data('name');
				var file  = document.querySelector('#file').files[0];

				if (image == 'custom' && file !== undefined) {
					var promise = this.getBase64(file);
					var vm      = this;
					promise.then(function(result) {
					    data.photo = result;
						vm.postAjax(data, post_url, current_item, domain_id);
					});
				} else {
					data.photo = image;
						this.postAjax(data, post_url, current_item, domain_id);

				}
 
				return false;
			},
			postAjax: function(data, post_url, current_item, domain_id) {
				if (this.checkFakeTime(data.fake_locale)) {
					$('#campaign-preloader').fadeIn('fast');
					$.ajax({
		                type: "POST",
		                url: post_url,
		                data: data,
		                success: function(result) {
		                	if (result == 'success') {

		                		if (current_item == 'save-updates') {
		                			setTimeout(function(){

							        	var list = $('.add-module-tab input');
							        	$.each(list, function(index, item) {
							        		$(item).data('value', $(item).val());
							        	});

				 						$('.module_example_block.edit-info-block').removeClass('alert');
				 						$('.module_example_block.edit-info-block span').html($('.module_example_block.edit-info-block span').data('default'));		

		                				$('#campaign-preloader').fadeOut('fast')
								        document.getElementById('alert-notification').className += ' show';
								        setTimeout(function(){
								    		document.getElementById('alert-notification').className = 'alert-notification';
								        }, 3000);
		                			}, 1000);
		                		} else {
		                			window.location.replace("/admin/domains/" + domain_id);		                			
		                		}
		                	}
		                }
		            });
				}
			},
			changeImage: function() {
				this.readURL($('#file')[0]);
				$('.icon-elem').removeClass('active');
				var path = $('#file')[0].value;
				var filename = path.replace(/^.*\\/, "");
				$('.icon-elem:first-child').css('display', 'inline-block');		
				$('.icon-elem:first-child').addClass('active');
				$('#file').parent().next().text(filename);
			},
			activeImage: function(el) {

				if (el.hasClass('active')) {
					//$('.icon-elem').removeClass('active');
				} else {
					$('.icon-elem').removeClass('active');
					el.addClass('active')
				}
 
			},
			checkFakeTime: function(data) {
				var arr      = data.split(';');	
				var minutes  = {'m': 1, 'h': 60, 'd': 1440};
        		var fake_yes = $('input[name="fake"]:checked').val();

        		if(fake_yes != 'no') {

					if (arr.length == 4) {
						if (((arr[0] != '' && arr[2] != '') && (Number.isInteger(parseInt(arr[0])) && Number.isInteger(parseInt(arr[2])))) & (minutes.hasOwnProperty(arr[1]) && minutes.hasOwnProperty(arr[3]))) {
							var min = arr[0] * minutes[arr[1]];
							var max = arr[2] * minutes[arr[3]];
							if(parseInt(min) >= parseInt(max)) {
								$('#time-from').addClass('error');
								$('#time-to').addClass('error');
								return false;
							} else {
								$('#time-from').removeClass('error');
								$('#time-to').removeClass('error');		
								return true;
							}
						} else {
							$('#time-from').addClass('error');
							$('#time-to').addClass('error');
							return false;
						}
					} else {
						$('#time-from').addClass('error');
						$('#time-to').addClass('error');
						return false;		
					}
				} else {
					return true;
				}
			},
			// bind events handler
	        bindEventHandlers: function() {
	            for (var i =0 ; i < this.eventHandlers.length; i++) {
	                this.bindEvent(this.eventHandlers[i]);
	            }
	        },
	        bindEvent: function(e) {
	        	//$(document).on(e.event, e.$el, e.handler);
				e.$el.on(e.event, e.handler);
	            //console.log('Bound ' + e.event + ' handler for', e.$el);
	        },
	        // events list
	        eventHandlers: [
	            {
	                $el: $('.module_step_item'),
	                event: "click",
	                handler: function(){ return AddnewModule.changeTab($(this)); }
	            },
	            {
	                $el: $('#addModuleNextStep'),
	                event: "click",
	                handler: function(){ return AddnewModule.nextStep(); }
	            },
	            {
	                $el: $('#message'),
	                event: "keyup",
	                handler: function(){ return AddnewModule.countMessageFieldLength($(this)); }
	            },
	            {
	                $el: $('#url_name'),
	                event: "keypress",
	                handler: function(event){ if(event.keyCode == 13){ return AddnewModule.captureAddURL($(this),'#capture-list'); }  }
	            },
	            {
	                $el: $('#where_show_notifications'),
	                event: "keypress",
	                handler: function(event){ if(event.keyCode == 13){ return AddnewModule.captureAddURL($(this),'#show-list'); }  }
	            },
	            {
	                $el: $('a.delete_url_item'),
	                event: "click",
	                handler: function(){ return AddnewModule.captureRemoveURL($(this)); }
	            },
	            {
	                $el: $('#finishModuleStep'),
	                event: "click",
	                handler: function(){ return AddnewModule.addModule($(this)); }
	            },
	            {
	                $el: $('#save-updates'),
	                event: "click",
	                handler: function(){ return AddnewModule.addModule($(this)); }
	            },
	            {
	                $el: $('#addModuleBackStep'),
	                event: "click",
	                handler: function(){ return AddnewModule.backStep($(this)); }
	            },
	            {
	                $el: $('#addCaptureUrl'),
	                event: "click",
	                handler: function(){ return AddnewModule.captureAddURL($('#url_name'),'#capture-list'); }
	            },
	            {
	                $el: $('#addShowUrl'),
	                event: "click",
	                handler: function(){ return AddnewModule.captureAddURL($('#where_show_notifications'),'#show-list'); }
	            },
	            {
	                $el: $('input[name="show_main"]'),
	                event: "click",
	                handler: function(){ return AddnewModule.showMain(); }
	            },
	            {
	                $el: $('input[name="show_all"]'),
	                event: "click",
	                handler: function(){ return AddnewModule.showAll(); }
	            },
	            {
	                $el: $('#updateSettings'),
	                event: "click",
	                handler: function(){ return AddnewModule.updateSettings(); }
	            },
	            {
	                $el: $('#file'),
	                event: "change",
	                handler: function(){ return AddnewModule.changeImage($(this)); }
	            },
	            {
	                $el: $('#addFakeCity'),
	                event: "click",
	                handler: function(){ return AddnewModule.addFakeCity(); }
	            },
 	            {
	                $el: $('.icon-elem'),
	                event: "click",
	                handler: function(){ return AddnewModule.activeImage($(this)); }
	            },

	        ]
	    };

	    AddnewModule.init();
	})();

});

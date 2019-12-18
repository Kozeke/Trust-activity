$(document).ready(function() {
    /*$('ul.jump_out_tabs_list').on('click', 'li:not(.active)', function() {
        $(this)
            .addClass('active').siblings().removeClass('active')
            .closest('div.jump_out_tabs').find('div.jump_out_tabs_content').removeClass('active').eq($(this).index()).addClass('active');

        var type = $(this).data('type');
 
        if (type == 'blocks') {
            var name = $('.item_blocks.active').attr('id');
            $('.setting_elements').removeClass('active');
            $('.setting_elements.setting_blocks').addClass('active');
            $('div[data-element="' + name + '"]').addClass('active');
        }

        if (type == 'pop_up') {
            var name = $('.item_pop_up.active').attr('id');
            $('.setting_elements').removeClass('active');
            $('.setting_elements.setting_pop_up').addClass('active');

            console.log(name);
        }
    });*/

    $('.position_item').click(function() {
        $(this).addClass('active').siblings().removeClass('active');
    });

    /*var element = $('.choose_color');

    element.each(function(index) {
       var id_element = $(this).attr('id');
       var start_color = $(this).css('color');
        choose_color_bg(id_element, start_color );
    });*/

    /*$(document).on('click', '.list-group-item .edit', function() {

        var name = $(this).data('name');

        $('.setting_blocks_item[data-name="' + name + '"] .choose_color');

        /*element.each(function(index) {
            var id_element = $(this).attr('id');
            var start_color = $(this).css('color');
            choose_color_bg(id_element, start_color );
        });
    });*/


    /*function choose_color_bg(id, color) {
        const pickr = new Pickr({
            el: '.show_choose_color',
            default: color,
            //default: '#FFFFFF',
            components: {
                preview: false,
                opacity: true,
                hue: true,

                interaction: {
                    hex: false,
                    rgba: false,
                    hsva: false,
                    input: true,
                    clear: false,
                    save: true
                }
            },
            onChange: function(hsva, instance) {
                //hsva;

                if (id == 'choose_color_background') {
                    $('#box').css('background-color', hsva.toHEX());                    
                }
                if (id == 'choose_color_overlay') {
                    $('.redactor_block').css('background-color', hsva.toHEX());                    
                }
                if (id == 'choose_color_border') {
                    $('#box').css('border-color', hsva.toHEX());                    
                }
                if (id == 'choose_color_shadow') {
                    var current = $('#box').css('box-shadow');
                    var pieces  = current.split(')');
                    $('#box').attr('data-sc', hsva.toHEX());
                    $('#box').css('box-shadow',  pieces[1] + ' ' + hsva.toHEX());                   
                }
 
                $('#' + id).find('.pcr-button').css('background', hsva.toHEX());
                $('#' + id).find('.choose_background_text').text(hsva.toHEX());
            },
            onSave: function(hsva, instance) {
                hsva;

                if (id == 'choose_color_background') {
                    $('#box').css('background-color', hsva.toHEX());                    
                }
                if (id == 'choose_color_overlay') {
                    $('.redactor_block').css('background-color', hsva.toHEX());                    
                }
                if (id == 'choose_color_border') {
                    $('#box').css('border-color', hsva.toHEX());                    
                }
                if (id == 'choose_color_shadow') {
                    //$('#box').css('background-color', hsva.toHEX());                    
                }

                $('#' + id).find('.choose_background_text').text(hsva.toHEX());
            }
        });

        $('#' + id).find('.pcr-button').append('<div class="choose_background_text"></div>');
        $('#' + id).find('.pcr-button').append('<div class="choose_background_arrow"></div>');

        var color_element = pickr.getColor();
        var text_color_element = color_element.toHEX();
        $('#' + id).find('.choose_background_text').text(text_color_element);
    }*/

    $(document).on('click', '.size_block span', function(e) {
        e.preventDefault();
        $(this).next('.size_list').addClass('open');
    });

    /*$('.size_list li').click(function(e) {
        e.preventDefault();
        $(this).addClass('active').siblings().removeClass('active');
        $(this).parent('.size_list').removeClass('open');

        var size_count = $(this).text();
        $(this).parent('.size_list').closest('.size_block').prev('.border_size_input').find('input').val(size_count);
    });*/

    $(document).on('click', function(e) {
        if (!$(e.target).closest(".size_block").length) {
            $('.size_list').removeClass('open');
        }
        e.stopPropagation();
    });

    /*$('.item_blocks').click(function() {
        $(this).addClass('active').siblings().removeClass('active');
        $('.setting_pop_up').removeClass('active');
        $('.setting_blocks').addClass('active');

        $(this).each(function() {
           var id_element = $(this).attr('id');

           $('.setting_blocks_item').each(function() {
              var data_element = $(this).data('element');

              if(id_element == data_element) {
                  $(this).addClass('active');
              } else {
                  $(this).removeClass('active');
              }

           });
        });
    });*/

    /*$('.jump_out_pop_up').click(function() {
        $('.setting_pop_up').addClass('active');
        $('.setting_blocks').removeClass('active');
        $('.item_blocks').removeClass('active');
    });*/


    $('.selectbox').styler();

    $("#upload_image").change(function() {
        $('#background_image').addClass('show');
        $('#upload_image + label span.upload_image_text').text('Upload new image');
    });

    $('#background_image .background_image_delete').click(function() {
        $('#background_image').removeClass('show');
        $('#upload_image + label span.upload_image_text').text('Upload image');
    });

    $('.view_img_item').click(function() {
        $(this).addClass('active').siblings().removeClass('active');
    });

});
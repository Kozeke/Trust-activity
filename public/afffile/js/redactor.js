$(document).ready(function() {
    $('ul.jump_out_tabs_list').on('click', 'li:not(.active)', function() {
        $(this)
            .addClass('active').siblings().removeClass('active')
            .closest('div.jump_out_tabs').find('div.jump_out_tabs_content').removeClass('active').eq($(this).index()).addClass('active');
    });

    $('.item_pop_up').click(function() {
        $(this).addClass('active').siblings().removeClass('active');

        $(this).each(function() {
            var id_pop_up = $(this).attr('id');
            console.log(id_pop_up);

            switch(id_pop_up) {
                case "small_pop_up":
                    $('.redactor_canvas').attr('id', 'small');
                    $('.choose_position').removeClass('full_width full_height');
                    $('.position_tl, .position_tr').removeClass('active');
                    textSizeCanvas();
                    break;

                case "medium_pop_up":
                    $('.redactor_canvas').attr('id', 'medium');
                    $('.choose_position').removeClass('full_width full_height');
                    $('.position_tl, .position_tr').removeClass('active');
                    textSizeCanvas();
                    break;

                case "large_pop_up":
                    $('.redactor_canvas').attr('id', 'large');
                    $('.choose_position').removeClass('full_width full_height');
                    $('.position_tl, .position_tr').removeClass('active');
                    textSizeCanvas();
                    break;

                case 'f_w_pop_up':
                    $('.redactor_canvas').attr('id', 'full_width');
                    $('.choose_position').removeClass('full_height').addClass('full_width');
                    $('.position_tl').addClass("active");
                    textSizeCanvas_FW();
                    break;

                case 'f_h_pop_up':
                    $('.redactor_canvas').attr('id', 'full_height');
                    $('.choose_position').removeClass('full_width').addClass('full_height');
                    $('.position_tl').removeClass("active");
                    $('.position_tr').addClass("active");
                    textSizeCanvas_FH();
                    break;

                default:
                    $('.redactor_canvas').removeAttr('id');
                    $('.choose_position').removeClass('full_width full_height');
                    $('.position_tl, .position_tr').removeClass('active');
                    textSizeCanvas();

            }

        });

    });

    function textSizeCanvas() {
        var width_size_canvas = $('.redactor_canvas').width();
        var height_size_canvas = $('.redactor_canvas').height();

        $('.width_size_canvas .width_size_count').text(width_size_canvas);
        $('.height_size_canvas .height_size_count').text(height_size_canvas);
        $('.width_size_canvas .width_size_units').text('px');
        $('.height_size_canvas .height_size_units').text('px');
    }
    textSizeCanvas();

    function textSizeCanvas_FW() {
        var height_size_canvas = $('.redactor_canvas').height();

        $('.width_size_canvas .width_size_count').text('100');
        $('.height_size_canvas .height_size_count').text(height_size_canvas);
        $('.width_size_canvas .width_size_units').text('%');
        $('.height_size_canvas .height_size_units').text('px');
    }

    function textSizeCanvas_FH() {
        var width_size_canvas = $('.redactor_canvas').width();


        $('.width_size_canvas .width_size_count').text(width_size_canvas);
        $('.height_size_canvas .height_size_count').text('100');
        $('.width_size_canvas .width_size_units').text('px');
        $('.height_size_canvas .height_size_units').text('%');

    }

    $('.position_item').click(function() {
        $(this).addClass('active').siblings().removeClass('active');
    });

    var element = $('.choose_color');

    element.each(function(index) {
       var id_element = $(this).attr('id');
       var start_color = $(this).css('color');
        choose_color_bg(id_element, start_color );
    });

    function choose_color_bg(id, color) {
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
            onChange(hsva, instance) {
                hsva;
                $('#' + id).find('.pcr-button').css('background', hsva.toHEX());
                $('#' + id).find('.choose_background_text').text(hsva.toHEX());
            },
            onSave(hsva, instance) {
                hsva;
                $('#' + id).find('.choose_background_text').text(hsva.toHEX());
            }
        });

        $('#' + id).find('.pcr-button').append('<div class="choose_background_text"></div>');
        $('#' + id).find('.pcr-button').append('<div class="choose_background_arrow"></div>');

        var color_element = pickr.getColor();
        var text_color_element = color_element.toHEX();
        $('#' + id).find('.choose_background_text').text(text_color_element);
    }


    $('.size_block span').click(function(e) {
        e.preventDefault();
        $(this).next('.size_list').addClass('open');
    });

    $('.size_list li').click(function(e) {
        e.preventDefault();
        $(this).addClass('active').siblings().removeClass('active');
        $(this).parent('.size_list').removeClass('open');

        var size_count = $(this).text();
        $(this).parent('.size_list').closest('.size_block').prev('.border_size_input').find('input').val(size_count);
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest(".size_block").length) {
            $('.size_list').removeClass('open');
        }
        e.stopPropagation();
    });

    $('.item_blocks').click(function() {
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
    });

    $('.jump_out_pop_up').click(function() {
        $('.setting_pop_up').addClass('active');
        $('.setting_blocks').removeClass('active');
        $('.item_blocks').removeClass('active');
    });


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
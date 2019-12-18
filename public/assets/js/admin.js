$(document).ready(function() {

    //Скрытие label авторизация/регистрация
    var input = $('.sing_in_form .sign_form_row input');

    $(input).change(function() {
        if($(this).val() !='') {
            $(this).next('label').addClass('none');
        } else {
            $(this).next('label').removeClass('none');
        }
    });

    //Показать подсказку на значок вопроса

    $('.question_icon').click(function(e) {
        e.preventDefault();
        $(this).next('.question_fon').toggleClass('show_fon').next('.question_block_hidden').toggleClass('open_question');
    });

    // $(document).on('click touchstart', function(e) {
    //     if (!$(e.target).closest(".question").length) {
    //         $('.question_block_hidden').removeClass('open_question');
    //     }
    //     e.stopPropagation();
    // });

    $('.question_fon').click(function(e) {
        e.preventDefault();
        $(this).next('.question_block_hidden').removeClass('open_question');
        $(this).removeClass('show_fon');
    });

    $('.question_block_ok').click(function() {
        $('.question_block_hidden').removeClass('open_question');
        $('.question_fon').removeClass('show_fon');
        return false;
    });

    //Показать модальное окно
    $('.add_domain button').click(function() {
       $('.add_domain_modal').addClass('show_modal');
       //$('body, html').addClass('overflow');
       return false;
    });

    //Скрыть модальное окно
    $('.domain_modal_fon').click(function(){
        $('.add_domain_modal').removeClass('show_modal');
        $('.question_fon').removeClass('show_fon');
        $('.question_block_hidden').removeClass('open_question');
        //$('body, html').removeClass('overflow');
    });


    //Табы на странице Domain
    $('.notification_tabs ul').on('click', 'li:not(.active)', function() {
        $(this)
            .addClass('active').siblings().removeClass('active')
            .closest('div.notification_tabs').find('div.notification_tabs_content').removeClass('active').eq($(this).index()).addClass('active');
    });


    //Показать код скрипта
    $('.view_code_link').click(function() {
        $('.code_block_content').slideDown();
        $(this).addClass('opacity');
        $('.hide_code_link').removeClass('opacity');
        return false;
    });

    //Скрыть код скрипта
    $('.hide_code_link').click(function() {
        $('.code_block_content').slideUp();
        $(this).addClass('opacity');
        $('.view_code_link').removeClass('opacity');
        return false;
    });

    //Копирование кода
    // var clipboard = new ClipboardJS('.copy_link p');
    //
    // clipboard.on('success', function(e) {
    //     console.log(e);
    // });
    //
    // clipboard.on('error', function(e) {
    //     console.log(e);
    // });


    //Контакты
    $('.contacts_link').click(function() {
       $('.contacts_block').addClass('show_contacts');
       $('body,html').addClass('overflow');
       return false;
    });

    $('.contacts_block_fon').click(function() {
        $('.contacts_block').removeClass('show_contacts');
        $('body,html').removeClass('overflow');
    });

    //Табы в метрике
    $('.metrics_tabs ul').on('click', 'li:not(.active)', function() {
        $(this)
            .addClass('active').siblings().removeClass('active')
            .closest('div.metrics_tabs').find('div.metrics_tabs_content').removeClass('active').eq($(this).index()).addClass('active');
    });

    //Метрика
    $('.metrics_link').click(function() {
        $('.metrics_block').addClass('show_metrics');
        $('body,html').addClass('overflow');
        return false;
    });

    $('.metrics_block_fon').click(function() {
        $('.metrics_block').removeClass('show_metrics');
        $('body,html').removeClass('overflow');
    });

//Показать/Скрыть блок с вводом кода на странице Sign Up
    $('input#bonus_code').change(function() {
        if($(this).is(':checked')) {
            $('.bonus_row_input ').slideDown();
        } else {
            $('.bonus_row_input ').slideUp();
        }
    });

//Если выбран notification - показать тариф
    $('input.check_campaign').change(function() {
       if($(this).is(':checked')) {
           $(this).closest('.dashboard_campaign_title').next('.dashboard_choose_rate').slideDown();
       } else {
           $(this).closest('.dashboard_campaign_title').next('.dashboard_choose_rate').slideUp();
       }
    });
console.log('loaded');
//Открытие/закрытие выбора тарифа на странице Dashboard
    $('.choose_rate_value').click(function() {
        console.log('test');
       $(this).next('.choose_rate_list').toggleClass('show_choose_list');
    });

//Изменение текста выбранного тарифа и закрытие блока с тарифами
    $('.choose_rate_list li').click(function() {
        var name_rate = $(this).find('.name_rate').text();
        var settings_rate = $(this).find('.settings_rate').text();
        settings_rate = settings_rate.replace('Unique', '');
        console.log(name_rate);
        console.log(settings_rate);
        $(this).closest('.dashboard_choose_rate').find('.choose_rate_value').find('p.choose_rate_name').text(name_rate);
        $(this).closest('.dashboard_choose_rate').find('.choose_rate_value').find('p.choose_rate_settings').text(settings_rate);
        $(this).closest('.choose_rate_list').removeClass('show_choose_list');
        //console.log(name_rate);
    });

})
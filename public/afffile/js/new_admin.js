//Для стилизации скролла    
    $('.sidebar').scrollbar();

    $('.dashboard_check_list').scrollbar();    



//Для оплаты неактивного модуля

    $('.link_disabled_fon a').click(function() {
        $('.active_domain_block').addClass('show_active_domain');
        $('body,html').addClass('overflow');
        return false;
    });

    $('.active_domain_fon').click(function() {
        $('.active_domain_block').removeClass('show_active_domain');
        $('body,html').removeClass('overflow');
        $('.active_domain_plan_item').removeClass('active').fadeIn();
        $('.change_active_domain_plan').fadeOut();
        $('.active_domain_payment').fadeOut();
        $('.active_domain_link').fadeOut();
    });


    $('.active_domain_plan_item').click(function() {
        $(this).addClass('active').siblings().removeClass('active');
        $('.active_domain_plan_item').fadeOut('fast');
        $('.active_domain_payment').fadeIn();
        $('.change_active_domain_plan').fadeIn();
    });

    $('.active_domain_payment_item').click(function() {
        $(this).addClass('active').siblings().removeClass('active');
        $('.active_domain_link').fadeIn();
    });

    $('.change_active_domain_plan').click(function() {
        $('.active_domain_plan_item').fadeIn('fast');
        $('.active_domain_link').fadeOut();
        $('.active_domain_payment_item').removeClass('active');
        $(this).fadeOut();
    });
// Disable notify
process.env.DISABLE_NOTIFIER = true

// I need some magic
const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');


elixir(function(mix) {
	mix.webpack('app.js');
	mix.styles([
	    'bootstrap.css',
	    'bootstrap-theme.min.css',
	    'slick.css',
	    'jquery.fancybox.min.css',
	    'style.min.css',
	    'media.min.css',
	], 'public/css/style.min.css')
	mix.styles([
	    'truster/truster.css',
	], 'public/cdn/truster.css')
	mix.styles([
	    'jumpout/jquery.formstyler.css',
	    'jumpout/jquery.formstyler.theme.css',
	    'jumpout/jump_out.css',
	    'jumpout/pickr.min.css',
	    'jumpout/redactor.css',    	    
	], 'public/css/jumpout.min.css')
	mix.styles([
	    'faq.css',
	], 'public/css/faq.min.css')
	.scripts([
	    'js/jquery-3.3.1.min.js',
	    'js/bootstrap.js',
	    'js/Headroom.js',
	    'js/jQuery.headroom.js',
	    'js/slick.js',
	    'js/jquery.fancybox.min.js',
	    'js/main.min.js'
	], 'public/js/scripts.min.js')
	.styles([
	    'bootstrap.css',
	    'jquery.formstyler.css',    
	    'bootstrap-theme.min.css',
	    'admin.min.css',
	    'admin_media.min.css', 
	    'bootstrap-datepicker.min.css',
	    'custom.css'
	], 'public/css/panel.css')
	.scripts([
	    'js/jquery-3.3.1.min.js',
	    'js/jquery.formstyler.min.js',
	    'js/masked.min.js',    
	    'js/bootstrap.js',
	    'js/bootstrap-datepicker.min.js',
	    'js/clipboard.js',
	    'js/admin.min.js',
	    'js/custom.js',
	    'js/domains.js',
	    'js/affiliate.js',    
	], 'public/js/panel.js')
	.scripts([
	    'js/jquery-3.3.1.min.js',
	    'js/pickr.min.js',
	    'js/jquery.formstyler.min.js',
	    'js/redactor.js',
	], 'public/js/redactor.js')
	.scripts([
	    'truster/truster.js',
	], 'public/cdn/truster.js')
});
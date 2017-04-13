const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */
elixir((mix) => {
  mix.styles(['libs/style.default.css', 'libs/dropzone.css'], 'public/css/libs.css')
    .scripts([
    	'libs/jquery-1.11.1.min.js',
    	'libs/jquery-migrate-1.2.1.min.js',
    	'libs/bootstrap.min.js',
    	'libs/modernizr.min.js',
    	'libs/jquery.sparkline.min.js',
    	'libs/toggles.min.js',
    	'libs/retina.min.js',
    	'libs/jquery.cookies.js',
    	'libs/bootstrap-wizard.min.js',
    	'libs/select2.min.js',
    	'libs/dropzone.min.js',
    	'libs/custom.js'
	], 'public/js/libs.js')
});
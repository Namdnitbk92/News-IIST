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
 var path_gentelella = 'node_modules/gentelella/production/js';
 var path_gentelella_vendors = 'node_modules/gentelella/vendors/';
elixir((mix) => {
	mix.copy('node_modules/gentelella/production/images', 'public/images')
	.copy('node_modules/font-awesome/fonts', 'public/fonts')
	.copy('node_modules/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js', 'resources/assets/js')
	.copy(path_gentelella_vendors + 'nprogress/nprogress.js', 'resources/assets/js')
	.copy('node_modules/gentelella/build/js/custom.js', 'resources/assets/js')
	.copy(path_gentelella_vendors + 'iCheck/icheck.js', 'resources/assets/js');
    mix.sass('app.scss')
       .scripts(
       	[
			'bootstrap-progressbar.min.js',
			'icheck.js',
			'nprogress.js',
       	],
       	'public/js/libs.js')
       .scripts(['custom.js'], 'public/js/custom.js')
       .version('css/app.css', 'js/libs.js');
});
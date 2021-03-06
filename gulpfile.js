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
  mix.sass('app.scss')
  	.less('table.less', 'public/css/table.css')
    .webpack('app.js')
    .scripts(['libs/bootstrap.fd.js', 'custom.js', 'libs/lazyload.js'], 'public/js/custom.js')
    .version('css/app.css');
});
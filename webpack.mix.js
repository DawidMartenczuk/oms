const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

let version = '1.0';

mix.js('resources/js/bootstrap.js', 'front/' + version + '/js')
   .js('resources/js/cart.js', 'front/' + version + '/js')
   .sass('resources/sass/app.scss', 'front/' + version + '/css');
   
mix.minify('public/front/' + version + '/js/app.js');
mix.minify('public/front/' + version + '/js/cart.js');

mix.minify('public/front/' + version + '/css/app.css');
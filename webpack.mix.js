let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |.sass('resources/resources/assets/sass/app.scss', 'public/css');
 */


mix.js('resources/assets/js/confetti.js', 'public/js/confetti.js')

.js('resources/assets/js/app.js', 'public/js/app.js');

mix.styles([
    'public/js/plugins/owlcarousel/owl.carousel.min.css',
    '\'public/js/plugins/owlcarousel/owl.theme.default.css',

 ], 'public/js/plugins/owl.css');


mix.styles([
    'public/css/style.css',
    'public/css/gexs.css',
    'public/css/glyphicons.css',
], 'public/css/es.css');




mix.js([


    'public/js/plugins/jquery.ui.widget.js',
    'public/js/plugins/jquery.iframe-transport.js',
    'public/js/plugins/jquery.fileupload.js',

], 'public/js/plugins/upload.js').version();


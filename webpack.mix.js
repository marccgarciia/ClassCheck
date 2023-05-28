const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);
mix.js('resources/js/calendarAlu.js', 'public/js');
mix.js('resources/js/calendarProf.js', 'public/js');
mix.js('resources/js/cursosAlu.js', 'public/js');
mix.js('resources/js/cursosP.js', 'public/js');
mix.js('resources/js/datos.js', 'public/js');
mix.js('resources/js/faltasProf.js', 'public/js');
mix.js('resources/js/gestionAdmin.js', 'public/js');
mix.js('resources/js/horarioAlu.js', 'public/js');
mix.js('resources/js/pasarLista.js', 'public/js');
mix.js('resources/js/qrcode.js', 'public/js');


mix.css('resources/css/stylesdatos.css', 'public/css');

mix.css('resources/css/stylesfaltasprof.css', 'public/css');

mix.css('resources/css/styleshorario.css', 'public/css');

mix.css('resources/css/styleslayout.css', 'public/css');

mix.css('resources/css/styleslogin.css', 'public/css');

mix.css('resources/css/stylesmodal.css', 'public/css');

mix.css('resources/css/stylespassword.css', 'public/css');


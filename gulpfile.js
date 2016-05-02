var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');
});
// elixir(function (mix) {
//     mix.clean()
//         .sass('*.scss')
//         .wiredep()
//         .jshint()
//         .sync('resources/assets/js/**/*.js', 'public/js');

//     if (elixir.config.production) {
//         mix.useref({ src: false })
//             .version(['js/*.js', 'css/*.css'])
//     }
// });
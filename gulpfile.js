var elixir = require('laravel-elixir');

var paths = {
    'bower': './vendor/bower_components/',
    'boot': './vendor/bower_components/bootstrap-sass/assets/'
};

elixir(function(mix) {
    mix.sass('app.scss')

        .copy(paths.boot + 'fonts/bootstrap/**', 'public/fonts')

        .styles([
            './public/css/app.css'
        ])

        .scripts([
            paths.bower + 'jquery/dist/jquery.js',
            paths.boot + 'javascripts/bootstrap.js',
            'vendor/**',
            'custom/**'
        ])

        .browserify('vue/app.js', 'public/js/bundle.js')

        .version(['css/all.css', 'js/all.js', 'js/bundle.js'])
});

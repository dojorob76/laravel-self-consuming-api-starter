var elixir = require('laravel-elixir');

var paths = {
    'bower': './vendor/bower_components/',
    'boot': './vendor/bower_components/bootstrap-sass/assets/'
};

elixir(function(mix) {
    mix.sass('app.scss')

        .copy(paths.boot + 'fonts/bootstrap/**', 'public/fonts')
        .copy(paths.bower + 'font-awesome/fonts/**', 'public/fonts')

        .styles([
            paths.bower + 'font-awesome/css/font-awesome.css',
            paths.bower + 'select2/dist/css/select2.css',
            paths.bower + 'select2-bootstrap-css/select2-bootstrap.css',
            './public/css/app.css'
        ])

        .scripts([
            paths.bower + 'jquery/dist/jquery.js',
            paths.bower + 'select2/dist/js/select2.full.js',
            paths.boot + 'javascripts/bootstrap.js',
            'vendor/**',
            'custom/**'
        ])

        .browserify('vue/app.js', 'public/js/bundle.js')

        .version(['css/all.css', 'js/all.js', 'js/bundle.js'])
});

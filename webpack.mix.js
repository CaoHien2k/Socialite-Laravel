const mix = require('laravel-mix');
mix.styles('resources/css/app.css', 'public/css/styles.css').sourceMaps();
mix.sass('resources/sass/app.scss', 'public/css/app.css').sourceMaps();
mix.autoload({
    jquery: ['$', 'window.jQuery']
});


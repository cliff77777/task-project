const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
.sass('resources/sass/app.scss', 'public/css', {
    sassOptions: {
        includePaths: ['node_modules']
    }
})
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);
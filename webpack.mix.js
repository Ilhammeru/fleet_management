require('dotenv').config();
const mix = require('laravel-mix');

mix.sass('resources/css/main.scss', 'public/dist')
    .sass('resources/css/auth.scss', 'public/dist')
    .js('resources/js/app.js', 'public/dist')
    .js('resources/js/auth.js', 'public/dist')
    .js('resources/js/order.js', 'public/dist')
    .webpackConfig({
        optimization: {
            providedExports: false,
            sideEffects: false,
            usedExports: false
        },
        mode: "production",
    })
    .version();

// const mix = require('laravel-mix');

// /*
//  |--------------------------------------------------------------------------
//  | Mix Asset Management
//  |--------------------------------------------------------------------------
//  |
//  | Mix provides a clean, fluent API for defining some Webpack build steps
//  | for your Laravel application. By default, we are compiling the Sass
//  | file for the application as well as bundling up all the JS files.
//  |
//  */

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css')
//     .sourceMaps();



// ******************************************************** Khaled ////////////////////////
const mix = require('laravel-mix');
const webpack = require('webpack');

mix.js('resources/js/app.js', 'public/js')
.webpackConfig({
    plugins: [
        new webpack.DefinePlugin({
            'process.env.MIX_PUSHER_APP_KEY': JSON.stringify(process.env.PUSHER_APP_KEY),
            'process.env.MIX_PUSHER_APP_CLUSTER': JSON.stringify(process.env.PUSHER_APP_CLUSTER),
            'process.env.MIX_PUSHER_HOST': JSON.stringify(process.env.PUSHER_HOST), // added
            'process.env.MIX_PUSHER_PORT': JSON.stringify(process.env.PUSHER_PORT), // added
        }),
    ],
});

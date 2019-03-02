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

mix.setPublicPath('public');

mix.sass('resources/sass/frontend/app.scss', 'css/frontend.css')
    .sass('resources/sass/backend/app.scss', 'css/backend.css')
    .js('resources/js/frontend/app.js', 'js/frontend.js')
    .js([
        'resources/js/backend/before.js',
        'resources/js/backend/app.js',
        'resources/js/backend/after.js'
    ], 'js/backend.js')
    .extract([
        'jquery',
        'bootstrap',
        'popper.js/dist/umd/popper',
        'axios',
        'sweetalert2',
        'lodash',
        '@fortawesome/fontawesome-svg-core',
        '@fortawesome/free-brands-svg-icons',
        '@fortawesome/free-regular-svg-icons',
        '@fortawesome/free-solid-svg-icons'
    ]);

if (mix.inProduction() || process.env.npm_lifecycle_event !== 'hot') {
    mix.version();
}

mix.options({
    hmrOptions: {
        host: 'laravel-boilerplate.dev.local',
    }
});

// // fix css files 404 issue
mix.webpackConfig({
    devServer: {

        // https: {
        //     key: '/etc/ssl/private/default.key',
        //     cert: '/etc/ssl/private/default.crt',
        //     ca: '/etc/ssl/private/dhparam.pem',
        // },
        proxy: {
            host: '0.0.0.0',
            port: 8080,
            '/route':{
                target: 'https://laravel-boilerplate.dev.local',
            },
            '/api':{
                target: 'https://laravel-boilerplate.dev.local:443',
                ws: true,
                changeOrigin: true,

            }
        },
        watchOptions:{
            aggregateTimeout:200,
            poll:5000
        },
        // plugins: [
        //     new webpack.EnvironmentPlugin(['MIX_PUBLISH_APP_URL']),
        // ],
    }
});

let mix = require('laravel-mix');

mix.setPublicPath('/');
mix.options({
    processCssUrls: false
});

mix.copy( 'node_modules/sweetalert2/dist/sweetalert2.min.css', 'admin/css/sweetalert2.min.css' );
mix.copy( 'node_modules/sweetalert2/dist/sweetalert2.min.css', 'public/css/sweetalert2.min.css' );

mix.copy( 'node_modules/sweetalert2/dist/sweetalert2.min.js', 'admin/js/sweetalert2.min.js' );
mix.copy( 'node_modules/sweetalert2/dist/sweetalert2.min.js', 'public/js/sweetalert2.min.js' );
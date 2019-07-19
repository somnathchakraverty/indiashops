let mix = require('laravel-mix');

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

/***FOR DESKTOP***/

if (mix.inProduction()) {
    mix.copyDirectory('public/build', 'public/backup/build');
}

mix.styles([
    'assets/v3/css/bootstrap.css',
    'assets/v3/css/style.css',
    'assets/v2/css/jquery-ui.css',
], 'public/build/css/app.css')
    .version();

/***FOR MOBILE***/
mix.styles([
    'assets/v3/mobile/css/style.css',
], 'public/build/mobile/css/app.css')
    .version();

mix.js([
    'assets/v3/js/bootstrap.min.js',
    'assets/v3/js/jquery.lazyloadxt.min.js',
    'assets/v3/js/modernizr.min.js',
    'assets/v3/js/jquery.menu-aim.js',
    'assets/v3/js/main.js',
    'assets/v3/js/css-carousel.js',
    'assets/v3/js/exit_popup.js',
    'assets/v3/js/compare.js',
    'assets/v3/js/notifications.js',
    'assets/v3/js/front.js',
], 'public/build/js/bottom.js')
    .version();

/***FOR MOBILE***/
mix.js([
    'assets/v3/js/jquery.lazyloadxt.min.js',
    'assets/v3/mobile/js/css-carousel.js'
], 'public/build/mobile/js/bottom.js')
    .version();

mix.js([
    'assets/v3/js/bootstrap.min.js',
    'assets/v3/js/jquery.lazyloadxt.min.js',
    'assets/v3/js/modernizr.min.js',
    'assets/v3/js/jquery.menu-aim.js',
    'assets/v3/js/main.js',
    'assets/v3/js/exit_popup.js',
    'assets/v3/js/compare.js',
    'assets/v3/js/productlist.js',
    'assets/v3/js/css-carousel.js',
    'assets/v3/js/front.js',
], 'public/build/js/listing.js')
    .version();

/***FOR MOBILE***/
mix.js([
    'assets/v3/js/jquery.lazyloadxt.min.js',
    'assets/v3/mobile/js/productlist.js'
], 'public/build/mobile/js/listing.js')
    .version();

mix.js([
    'assets/v3/js/bootstrap.min.js',
    'assets/v3/js/jquery.lazyloadxt.min.js',
    'assets/v3/js/modernizr.min.js',
    'assets/v3/js/jquery.menu-aim.js',
    'assets/v3/js/main.js',
    'assets/v3/js/exit_popup.js',
    'assets/v3/js/compare.js',
    'assets/v3/js/jquery.simpleGallery.js',
    'assets/v3/js/jquery.simpleLens.js',
    'assets/v3/js/css-carousel.js',
    'assets/v3/js/productdetail.js',
    'assets/v3/js/thumbelina.js',
    'assets/v3/js/front.js',
], 'public/build/js/detail.js')
    .version();

/***FOR MOBILE***/
mix.js([
    'assets/v3/js/jquery.lazyloadxt.min.js',
    'assets/v3/mobile/js/product/jquery.simpleLens.js',
    'assets/v3/mobile/js/product/jquery.simpleGallery.js',
    'assets/v3/mobile/js/thumbelina.js',
    'assets/v3/mobile/js/main.js',
], 'public/build/mobile/js/detail.js')
    .version();

mix.js([
    'assets/v3/js/bootstrap.min.js',
    'assets/v3/js/jquery.flexisel.js',
    'assets/v3/js/jquery.lazyloadxt.min.js',
    'assets/v3/js/css-carousel.js',
    'assets/v3/js/jquery.menu-aim.js',
    'assets/v3/js/modernizr.min.js',
    'assets/v3/js/main.js',
], 'public/build/js/coupons.js').version();

mix.js([
    'assets/v3/js/jquery.lazyloadxt.min.js',
    'assets/v3/js/css-carousel.js',
    'assets/v3/js/jquery.menu-aim.js',
    'assets/v3/js/modernizr.min.js',
    'assets/v3/js/main.js',
], 'public/build/mobile/js/coupons.js').version();

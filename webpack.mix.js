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

mix.sass('resources/assets/scss/card-dashboard.scss', 'public/assets/css/card-dashboard.css');
mix.sass('resources/assets/scss/time-line.scss', 'public/assets/css/time-line.css');

mix.combine([
    'resources/assets/plugins/moment/moment.min.js',
    'resources/assets/plugins/moment/ptbr.js',
    'resources/assets/plugins/blockui.min.js',
    'resources/assets/plugins/bootbox.min.js',
    'resources/assets/plugins/uniform.min.js',
    'resources/assets/plugins/jgrowl.min.js',
    'resources/assets/plugins/select2.min.js',
    'resources/assets/plugins/select2-ptBR.min.js',
    'resources/assets/plugins/validate.min.js',
    'resources/assets/plugins/validate_pt_BR.min.js',
    'resources/assets/plugins/validate-additional.js',
    'resources/assets/plugins/picker-legacy.js',
    'resources/assets/plugins/jquery.mask.min.js',
    'resources/assets/plugins/typeahead.bundle.min.js',
    'resources/assets/plugins/confirma-exclusao.js',
    'resources/assets/plugins/bootstrap-datepicker.min.js',
    'resources/assets/plugins/bootstrap-datepicker.pt-BR.min.js',
    'resources/assets/plugins/string-mask.js',
    'resources/assets/plugins/daterangepicker.js',
    'resources/assets/plugins/bootstrap_multiselect.js',
    'resources/assets/plugins/wysihtml5/wysihtml5.min.js',
    'resources/assets/plugins/wysihtml5/toolbar.js',
    'resources/assets/plugins/wysihtml5/bootstrap-wysihtml5.pt-BR.js',
    'resources/assets/plugins/dropzone.min.js',
    'resources/assets/plugins/sweet_alert.min.js',
    'resources/assets/plugins/attrchange.js',
    'resources/assets/plugins/jquery.maskMoney.min.js'

], 'public/assets/js/plugins.min.js');



mix.js('resources/assets/js/app.js', 'public/assets/js/app.min.js');

mix.webpackConfig({
    resolve: {
        alias: {
            pace: "pace-progress"
        }
    }
});

mix.browserSync({
    proxy: 'sinlog.dev',
    files: ["assets/**/*.css", "asstes/**/*.php", "asstes/**/*.js"],
    open: false
});

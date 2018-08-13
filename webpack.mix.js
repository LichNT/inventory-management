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
mix.styles([
    'public/css/boxsearch.css',
    'public/css/form.css',
    'public/css/select2.css',
    'public/css/table-report.css',
    'public/css/custom.css',
], 'public/css/all.css');

mix.js([
    'public/js/uploadimage.js',       
], 'public/js/min/uploadimage.min.js');

mix.js([
    'public/js/uploadfile.js',       
], 'public/js/min/uploadfile.min.js');

mix.js([
    'public/js/alert.js',       
    'public/js/checkbox.js',       
    'public/js/maskinput.js',       
    'public/js/select2.js',       
    'public/js/perpage.js',       
    'public/js/keypress.js',            
    'public/js/dropdown.js',                    
], 'public/js/min/base.min.js');
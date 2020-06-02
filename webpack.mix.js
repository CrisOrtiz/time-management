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
/**
 * PLUGINS
 */
mix

    //===images
    .copy('resources/images/login_background.jpg', 'public/images')  //spectrum color picker
    // ===== PLUGINS
    // Styles
    .sass('resources/sass/adminlte/AdminLTE.scss', 'public/css/adminlte.css') // Adminlte theme
    .copy('node_modules/icheck-bootstrap/icheck-bootstrap.min.css', 'public/css/') // I-check bootstrap
    .copy('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css', 'public/css/') // Datatables v4
    .copy('node_modules/sweetalert2/dist/sweetalert2.min.css', 'public/css/') // Sweetalert2
    .copy('node_modules/bootstrap-slider/dist/css/bootstrap-slider.min.css', 'public/css/plugins')//bootstrap slider
    .copy('resources/sass/plugins/switchery.min.css', 'public/css/plugins')//switchery
    .copy('node_modules/spectrum-colorpicker2/dist/spectrum.min.css', 'public/css/plugins')  //spectrum color picker

    //Scripts
    .js('resources/js/adminlte/AdminLTE.js', 'public/js/adminlte.js') // Adminlte theme
    .copy('node_modules/jquery/dist/jquery.min.js', 'public/js/') // Jquery
    .copy('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', 'public/js/') // Bootstrap
    .copy('node_modules/datatables.net/js/jquery.dataTables.min.js', 'public/js/') // Datatables
    .copy('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js', 'public/js/') // Datatables Bootstrap4
    .copy('node_modules/sweetalert2/dist/sweetalert2.min.js', 'public/js/') // Sweetalert2
    // .copy('resources/js/plugins/dataTables.editor.min.js', 'public/js/plugins')
    // .copy('resources/js/plugins/editor.bootstrap.min.js', 'public/js/plugins')
    // .copy('resources/sass/plugins/editor.dataTables.min.css', 'public/css/plugins')
    // .copy('resources/sass/plugins/editor.bootstrap.min.css', 'public/css/plugins')
    .copy('node_modules/bootstrap-slider/dist/bootstrap-slider.min.js', 'public/js/plugins')  //Bootstrap slider
    .copy('resources/js/plugins/switchery.min.js', 'public/js/plugins')    // Switchery
    .copy('node_modules/bootstrap-input-spinner/src/bootstrap-input-spinner.js', 'public/js/plugins')  //Bootstrap input spinner
    .copy('node_modules/spectrum-colorpicker2/dist/spectrum.min.js', 'public/js/plugins')  //spectrum color picker
    
   
    // Bootstrap Datepicker
    // .copy('resources/js/plugins/bootstrap-datepicker.min.js', 'public/js/plugins')
    // .copy('resources/sass/plugins/bootstrap-datepicker3.min.css', 'public/css/plugins')
    // ===== COMPONENTS
    .sass('resources/sass/components/vikor-table.scss', 'public/css/components')
    // ===== PAGES
    .js('resources/js/main.js', 'public/js')
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    // Login
    .sass('resources/sass/pages/login/login.scss', 'public/css/pages')
    
    //worker
    .js('resources/js/worker/home.js', 'public/js/worker')
    .js('resources/js/worker/list.js', 'public/js/worker')

     //manager
     .js('resources/js/manager/home.js', 'public/js/manager')
     .js('resources/js/manager/list.js', 'public/js/manager')
 
     //admin
     .js('resources/js/admin/home.js', 'public/js/admin')
     .js('resources/js/admin/list.js', 'public/js/admin')
 

if (mix.inProduction()) {
    mix.version();
}
    
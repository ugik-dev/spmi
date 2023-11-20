const mix = require('laravel-mix');


mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .scripts([
       'node_modules/jquery/dist/jquery.min.js',
       'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
       'node_modules/datatables.net/js/jquery.dataTables.min.js',
       'node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
       'node_modules/select2/dist/js/select2.min.js',
       'node_modules/sweetalert2/dist/sweetalert2.min.js',
       'node_modules/@popperjs/core/dist/umd/popper.min.js',
       'resources/js/vendor/jquery.easing.min.js',
       'resources/js/vendor/jquery.easing.compatibility.js',
       'resources/js/vendor/sb-admin-2.min.js',
   ], 'public/js/vendor.js')
   .styles([
       'node_modules/bootstrap/dist/css/bootstrap.min.css',
       'node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
       'node_modules/select2/dist/css/select2.min.css',
       'node_modules/sweetalert2/dist/sweetalert2.min.css',
       'resources/css/sb-admin-2.css',
   ], 'public/css/vendor.css')
   .copyDirectory('node_modules/@fortawesome/fontawesome-free', 'public/fontawesome')
   .copy('resources/images', 'public/images');

   if (!mix.inProduction()) {
    mix.sourceMaps();
}


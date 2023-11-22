const mix = require("laravel-mix");

mix
  .js("resources/js/app.js", "public/js")
  .js("resources/js/users-index.js", "public/js")
  .sass("resources/sass/app.scss", "public/css")
  .scripts(
    [
      "node_modules/jquery/dist/jquery.min.js",
      "node_modules/bootstrap/dist/js/bootstrap.bundle.min.js",
      "node_modules/datatables.net/js/jquery.dataTables.min.js",
      "node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js",
      "node_modules/select2/dist/js/select2.min.js",
      "node_modules/sweetalert2/dist/sweetalert2.min.js",
      "resources/js/vendor/jquery.easing.min.js",
      "resources/js/vendor/jquery.easing.compatibility.js",
      "resources/js/vendor/sb-admin-2.min.js",
    ],
    "public/js/vendor.js"
  )

  .copyDirectory(
    "node_modules/@fortawesome/fontawesome-free",
    "public/fontawesome"
  )
  .copy("resources/images", "public/images");

if (!mix.inProduction()) {
  mix.sourceMaps();
}

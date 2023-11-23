const mix = require("laravel-mix");
const webpack = require("webpack");

mix.webpackConfig({
  plugins: [
    new webpack.ProvidePlugin({
      $: "jquery",
      jQuery: "jquery",
      "window.jQuery": "jquery",
    }),
  ],
});

mix
  .js("resources/js/app.js", "public/js")
  .sass("resources/sass/app.scss", "public/css")

  .copyDirectory(
    "node_modules/@fortawesome/fontawesome-free",
    "public/fontawesome"
  )
  .copy("resources/images", "public/images");

if (!mix.inProduction()) {
  mix.sourceMaps();
}

const mix = require('laravel-mix');



mix.webpackConfig({

    externals: { Vue: 'vue' },

    plugins: [

    ],

   /*optimization: {

      minimize: false,

      runtimeChunk: true,

      removeAvailableModules: false,

      removeEmptyChunks: false,

      splitChunks: false  

   },*/

	resolve: {

      symlinks: false,

      

   }

})

/*

 |--------------------------------------------------------------------------

 | Mix Asset Management

 |--------------------------------------------------------------------------

 |

 | Mix provides a clean, fluent API for defining some Webpack build steps

 | for your Laravel applications. By default, we are compiling the CSS

 | file for the application as well as bundling up all the JS files.

 |

 */



 mix.js('resources/js/app.js', 'public/js')

 mix.js('resources/js/page.js', 'public/js')

    .sass('resources/scss/app.scss', 'public/css')

    .options({ processCssUrls: false }).version();

mix.disableNotifications();

mix.browserSync('http://balkun.test/');

mix.vue();
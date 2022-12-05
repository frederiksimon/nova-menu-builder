let path = require('path');
let mix = require('laravel-mix');
let postcss = require('postcss');
let tailwindcss = require('tailwindcss');

console.log(path.join(
  __dirname,
  '../../../../nova-menu-builder_node_modules/form-backend-validation/src/Errors.js'
))

mix
  .setPublicPath('dist')
  .js('resources/js/entry.js', 'js')
  .vue({ version: 3 })
  .webpackConfig({
    externals: {
      vue: 'Vue',
    },
    output: {
      uniqueName: 'outl1ne/nova-menu-builder-runner',
    },
    module: {
      rules: [
        {
          test: /\.tsx?$/,
          loader: "ts-loader",
          options: {
            allowTsInNodeModules: true
          }
        }
      ]
    }
  })
  .postCss('resources/css/entry.css', 'dist/css/', [postcss(), tailwindcss('tailwind.config.js')])
  .alias({
    'laravel-nova': path.join(
      __dirname,
      '../../vendor/laravel/nova/resources/js/mixins/packages.js'
    ),
    'form-backend-validation': path.join(
      __dirname,
      'node_modules/form-backend-validation/src/index.js'
    ),
    'vuex': path.join(
      __dirname,
      'node_modules/vuex/dist/vuex.esm-bundler.js'
    ),
    '@inertiajs/inertia': path.join(
      __dirname,
      'node_modules/@inertiajs/inertia/dist/index.js'
    ),
    'axios': path.join(
      __dirname,
      'node_modules/axios/index.js'
    )
  });

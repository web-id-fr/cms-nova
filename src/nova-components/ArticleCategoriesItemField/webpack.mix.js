let mix = require('laravel-mix')
const path = require('path')
require('./nova.mix')

mix
  .setPublicPath('dist')
  .js('resources/js/field.js', 'js')
  .vue({ version: 3 })
  .nova('webid/article-categories-item-field')
    .alias({
        'laravel-nova': path.join(__dirname, '../../vendor/laravel/nova/resources/js/mixins/packages.js'),
    });


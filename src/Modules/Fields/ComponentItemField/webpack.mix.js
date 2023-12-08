let mix = require('laravel-mix')
const path = require('path')
require('./nova.mix')

console.log(__dirname);
mix
  .setPublicPath('dist')
  .js('resources/js/field.js', 'js')
  .vue({ version: 3 })
  .nova('webid/component-item-field')

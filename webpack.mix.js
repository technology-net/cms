const mix = require('laravel-mix');
const path = require('path');
const dir = path.resolve(__dirname)
const resourcesPathCss = dir + '/resources/css/';
const resourcesPathJs = dir + '/resources/js/';
const publicPath = 'public/cms/';

mix
  .js(resourcesPathJs + 'create-common.js', publicPath + 'js/create-common.mix.js').version()
  .js(resourcesPathJs + 'slug.js', publicPath + 'js/slug.mix.js').version()
  .copy(dir + '/resources/images', publicPath + '/images');

const mix = require('laravel-mix');
const path = require('path');
const dir = path.resolve(__dirname)
const resourcesPathCss = dir + '/resources/css/';
const resourcesPathJs = dir + '/resources/js/';
const publicPath = 'public/cms/';

mix
  .js(resourcesPathJs + 'categories/form.js', publicPath + 'js/categories/form.js').version()
  .js(resourcesPathJs + 'slug.js', publicPath + 'js/slug.js').version();

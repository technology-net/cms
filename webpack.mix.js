const mix = require('laravel-mix');
const path = require('path');
const dir = path.resolve(__dirname)
const resourcesPathCss = dir + '/resources/css/';
const resourcesPathJs = dir + '/resources/js/';
const publicPath = 'public/cms/';

mix
  .js(resourcesPathJs + 'create-common.js', publicPath + 'js/create-common.js').version()
  .js(resourcesPathJs + 'posts/form.js', publicPath + 'js/posts/form.js').version()
  .js(resourcesPathJs + 'slug.js', publicPath + 'js/slug.js').version()
  .copy(dir + '/resources/images', publicPath + '/images');

let mix = require('laravel-mix');

mix
.js('resources/js/app.js', 'public/js')
.js('resources/js/vue/main.js', 'public/js')
.vue()
.sass('resources/sass/app.scss', 'public/scss')
.postCss('resources/css/app.css', 'public/css', [
	require('postcss-import'),

]);

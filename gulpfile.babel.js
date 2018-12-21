'use strict';

// This gulpfile makes use of new JavaScript features.
// Babel handles this without us having to do anything. It just works.
// You can read more about the new JavaScript features here:
// https://babeljs.io/docs/learn-es2015/

import gulp from 'gulp';
import pkg from './package.json';
import sftp from 'gulp-sftp';

import runSequence from 'run-sequence';
import browserSync from 'browser-sync';
const browsersync = require('browser-sync').create();
const reload = browserSync.reload;

import gulpLoadPlugins from 'gulp-load-plugins';
const $ = gulpLoadPlugins();

const ssi = require('browsersync-ssi');
const includer = require('gulp-html-ssi');
const ext_replace = require('gulp-ext-replace');
const string_replace = require('gulp-string-replace');
const imagemin = require('gulp-imagemin');
const app_path = '.';


// Optimize images
gulp.task('images', () =>
	gulp.src(app_path + '/assets/images/**/*')
	.pipe($.imagemin())
	.pipe(gulp.dest(app_path + '/dist/img'))
	.pipe($.size({
		title: 'images'
	}))
);

// Compile and automatically prefix stylesheets
gulp.task('styles', () => {
	const AUTOPREFIXER_BROWSERS = [
		'ie >= 10',
		'ie_mob >= 10',
		'ff >= 30',
		'chrome >= 34',
		'safari >= 7',
		'opera >= 23',
		'ios >= 7',
		'android >= 4.4',
		'bb >= 10'
	];

	// For best performance, don't add Sass partials to `gulp.src`
	return gulp.src([
			app_path + '/assets/styles/main.scss',
		])
		.pipe($.sourcemaps.init())
		.pipe($.sass({
			precision: 10
		}).on('error', $.sass.logError))
		.pipe($.autoprefixer(AUTOPREFIXER_BROWSERS))
		.pipe($.if('*.css', $.cssnano({
			discardComments: {
				removeAll: true
			}
		})))
		.pipe($.size({
			title: 'styles'
		}))
		.pipe($.sourcemaps.write('./'))
		.pipe(gulp.dest(app_path + '/dist/css'));
});

gulp.task('styles:wp', () => {
	const AUTOPREFIXER_BROWSERS = [
		'ie >= 10',
		'ie_mob >= 10',
		'ff >= 30',
		'chrome >= 34',
		'safari >= 7',
		'opera >= 23',
		'ios >= 7',
		'android >= 4.4',
		'bb >= 10'
	];

	// For best performance, don't add Sass partials to `gulp.src`
	return gulp.src([
			app_path + '/assets/styles/main.scss',
		])
		.pipe($.sourcemaps.init())
		.pipe($.sass({
			precision: 10
		}).on('error', $.sass.logError))
		.pipe($.autoprefixer(AUTOPREFIXER_BROWSERS))
		.pipe($.if('*.css', $.cssnano({
			discardComments: {
				removeAll: true
			}
		})))
		.pipe($.size({
			title: 'styles'
		}))
		.pipe($.sourcemaps.write('./'))
		.pipe(gulp.dest('/Applications/MAMP/htdocs/sitios-local/sitio-abs-colegios/wp-content/themes/abs-colegio/dist/css'));
});

//Styles watch
gulp.task('styles:watch', ['styles:wp'], () => {
	gulp.watch(app_path + '/assets/styles/**/*', ['styles:wp']);
});

// Concatenate and minify JavaScript. Optionally transpiles ES2015 code to ES5.
// to enable ES2015 support remove the line `'only': 'gulpfile.babel.js',` in the
// `.babelrc` file.
gulp.task('scripts', () =>
	gulp.src([
		app_path + '/assets/scripts/libs/*.js',
		app_path + '/assets/scripts/src/*.js',
		app_path + '/assets/scripts/*.js',
	])
	.pipe($.sourcemaps.init())
	.pipe($.babel())
	.pipe($.concat('main.min.js'))
	.pipe($.uglify({
		compress: true
	}))
	// Output files
	.pipe($.size({
		title: 'scripts'
	}))
	.pipe($.sourcemaps.write('.'))
	.pipe(gulp.dest(app_path + '/dist/js'))
);

//Styles watch
gulp.task('scripts:watch', ['scripts'], () => {
	gulp.watch(app_path + '/assets/scripts/**/*', ['scripts']);
});


//Concatenate and convert shtml to HTML files
//(include .html links)
gulp.task('shtml', () => {
	gulp.src(app_path + '/*.shtml')
		.pipe(includer())
		.pipe(ext_replace('.html'))
		.pipe(string_replace('.shtml', '.html'))
		.pipe(gulp.dest('./front'));
});


gulp.task('copy', () => {
	gulp.src([
			app_path + '/dist/**/*',
			app_path + '/partials/**/*',
		], {
			base: 'app'
		})
		.pipe(gulp.dest('./front'));
});

gulp.task('front', ['copy', 'shtml'], () => {});



/*************************** */
/*************************** */
/****Servers****** */
/*************************** */
/*************************** */



// Watch files for changes & reload
gulp.task('serve', ['scripts', 'styles', 'images'], () => {
	browserSync({
		notify: false,
		logPrefix: '**WSK**',
		scrollElementMapping: ['main', '.mdl-layout'],
		// https: true,
		// browser: 'firefox nightly',
		browser: 'google chrome',
		server: ['app'],
		port: 3004
	});

	gulp.watch([app_path + '/**/*.html'], reload);
	gulp.watch([app_path + '/assets/styles/**/**/*.{scss,css}'], ['styles', reload]);
	gulp.watch([app_path + '/assets/scripts/libs/*.js', app_path + '/assets/scripts/src/*.js'], ['scripts', reload]);
	gulp.watch([app_path + '/assets/images/**/*'], ['images', reload]);
});



//Watch using shtml
gulp.task('virtual', ['styles', 'scripts'], () => {
	browserSync({
		middleware: ssi({
			baseDir: 'app/',
			baseUrl: `http://localhost:3004`,
			ext: '.shtml',
			version: '1.4.0'
		}),
		notify: false,
		logPrefix: '**WSK**',
		server: ['app'],
		port: 3004,
		https: false

	});
	gulp.watch([app_path + '/**/*.shtml'], reload);
	gulp.watch([app_path + '/assets/styles/**/**/*.{scss,css}'], ['styles', reload]);
	gulp.watch([app_path + '/assets/scripts/libs/*.js', app_path + '/assets/scripts/src/*.js', app_path + '/assets/scripts/*.js'], ['scripts', reload]);
});

gulp.task('styles:sftp', ['styles'], () => {
	return gulp.src(app_path + '/dist/css/**')
		.pipe(sftp({
			'host': '52.26.30.123',
			'user': 'ubuntu',
			'keyLocation': '~/.ssh/idamazon.pem',
			'remotePath': '/var/www/develop/abs-colegio.dev.ida.cl/wp-content/themes/abs-colegio/dist/css/'
		}));
});

gulp.task('scripts:sftp', ['scripts'], () => {
	return gulp.src(app_path + '/dist/js/**')
		.pipe(sftp({
			'host': '52.26.30.123',
			'user': 'ubuntu',
			'keyLocation': '~/.ssh/idamazon.pem',
			'remotePath': '/var/www/develop/abs-colegio.dev.ida.cl/wp-content/themes/abs-colegio/dist/js/'
		}));
});

gulp.task('images:sftp', ['images'], () => {
	return gulp.src('./dist/img/**')
		.pipe(sftp({
			"host"     : "52.26.30.123",
			"user"     : "ubuntu",
      	"keyLocation": "~/.ssh/idamazon.pem",
			"remotePath" : "/var/www/develop/abs-colegio.dev.ida.cl/wp-content/themes/abs-colegio/dist/img/"
		}));
});


gulp.task('html:sftp', () => {
	return gulp.src(app_path + '/dist/html/*')
		.pipe(sftp({
			'host': '52.26.30.123',
			'user': 'ubuntu',
			'keyLocation': '~/.ssh/idamazon.pem',
			'remotePath': '/var/www/front/assa-abloy/'
		}));
});


gulp.task('styles:serve', ['styles:sftp'], () => {
	gulp.watch("assets/styles/**/*.{scss,css}", ['styles:sftp']);
});

gulp.task('scripts:serve', ['scripts:sftp'], () => {
	gulp.watch("assets/scripts/**/*.js", ['scripts:sftp']);
});


gulp.task('listen', ['scripts:sftp', 'styles:sftp'], () => {
	gulp.watch(app_path + '/assets/styles/**/**/*.{scss,css}', ['styles:sftp']);
	gulp.watch([app_path + '/assets/scripts/libs/**.js', app_path + '/assets/scripts/src/**.js', app_path + '/assets/scripts/**.js'], ['scripts:sftp']);
});

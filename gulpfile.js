'use strict';

var gulp = require('gulp');
var jshint = require('gulp-jshint');
var recess = require('gulp-recess');
var karma = require('gulp-karma');

gulp.task('jshint', function() {
	return gulp.src(['public/assets/js/**/*.js', 'spec/**/*.js', 'gulpfile.js'])
		.pipe(jshint())
		.pipe(jshint.reporter());
});

gulp.task('recess', function() {
	return gulp.src('public/assets/less/**/*.less')
		.pipe(recess());
});

gulp.task('karma', function () {
	var files = [
		'bower_components/jquery/dist/jquery.min.js',
		'bower_components/underscore/underscore.js',
		'bower_components/angular/angular.min.js',
		'bower_components/angular-route/angular-route.min.js',
		'bower_components/angular-mocks/angular-mocks.js',
		'bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js',
		'public/assets/js/app.js',
		'public/assets/js/controllers/**/*.js',
		'public/assets/js/directives/**/*.js',
		'public/assets/js/services/**/*.js',
		'spec/**/*Spec.js',
	];

	return gulp.src(files)
		.pipe(karma({configFile: 'karma.conf.js'}));
});

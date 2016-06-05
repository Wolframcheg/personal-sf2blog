var gulp = require('gulp'),
    less = require('gulp-less'),
    clean = require('gulp-rimraf'),
    concatJs = require('gulp-concat'),
    minifyJs = require('gulp-uglify'),
    sourcemaps = require('gulp-sourcemaps');


gulp.task('clean', function () {
    return gulp.src(['web/css/*', 'web/js/*', 'web/images/*', 'web/fonts/*', 'web/admin/*', 'web/front/*'])
        .pipe(clean());
});

gulp.task('front-js', function() {
    return gulp.src([
            'bower_components/jquery/dist/jquery.js',
            'bower_components/bootstrap/dist/js/bootstrap.js',
            'bower_components/bootstrap-material-design/dist/js/ripples.js',
            'bower_components/bootstrap-material-design/dist/js/material.js',
        ])
        .pipe(concatJs('app.js'))
        .pipe(minifyJs())
        .pipe(gulp.dest('web/front/js/'));
});

gulp.task('fonts', function () {
    return gulp.src(['bower_components/bootstrap/fonts/*'])
        .pipe(gulp.dest('web/front/fonts/'))
});

gulp.task('less', function() {
    return gulp.src(['web-src/less/*.less'])
        .pipe(less({compress: true}))
        .pipe(gulp.dest('web/front/css/'));
});

gulp.task('default', ['clean'], function () {
    var tasks = ['front-js', 'less', 'fonts'];
    tasks.forEach(function (val) {
        gulp.start(val);
    });
});




gulp.task('watch:less', ['front-less'], function () {
    gulp.watch('web-src/front/less/**/*.less', ['front-less']);
});
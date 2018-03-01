var localhost = 'http://sgfstaging.192.168.1.17.xip.io:8895/';//local dev url

var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    cssnano = require('gulp-cssnano'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    imagemin = require('gulp-imagemin'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    cache = require('gulp-cache'),
    sourcemaps = require('gulp-sourcemaps'),
    identityMap = require('@gulp-sourcemaps/identity-map'),

    browserSync = require('browser-sync').create(),
    del = require('del');

// Styles
gulp.task('styles', function() {
  return sass('app/sass/**/*.scss', { style: 'expanded' })

    .pipe(autoprefixer('last 2 version'))
    .pipe(sourcemaps.init())
    .pipe(identityMap()) // .js and .css files will get a generated sourcemap
  .pipe(sourcemaps.write())
    .pipe(gulp.dest('./'))
    .pipe(rename({ suffix: '.min' }))
    .pipe(cssnano())
    .pipe(gulp.dest('./'))
    .pipe(notify({ message: 'Style Compiled, now smile' }))
    .pipe(browserSync.stream());
});

// Scripts
gulp.task('scripts_custom', function() {
  return gulp.src('app/js/custom/**/*.js')
    .pipe(jshint())
    .pipe(jshint.reporter('default'))
    .pipe(concat('main.js'))
    .pipe(gulp.dest('./'))
    .pipe(rename({ suffix: '.min' }))
    .pipe(uglify())
    .pipe(gulp.dest('./'))
    .pipe(notify({ message: 'Custom JS Compiled and delinted' }))
    .pipe(browserSync.stream());
});

gulp.task('scripts_vendor', function() {
  return gulp.src('app/js/vendor/**/*.js')
   // .pipe(jshint())
   // .pipe(jshint.reporter('default'))
    .pipe(concat('vendor.js'))
    .pipe(gulp.dest('./'))
    .pipe(rename({ suffix: '.min' }))
    .pipe(uglify())
    .pipe(gulp.dest('./'))
    .pipe(notify({ message: 'vendor JS compiled and minified' }))
    .pipe(browserSync.stream());
});



// Images
gulp.task('images', function() {
  return gulp.src('app/images/**/*')
    .pipe(cache(imagemin({ optimizationLevel: 3, progressive: true, interlaced: true })))
    .pipe(gulp.dest('app/images'))
    .pipe(notify({ message: 'Images task complete' }));
});

// Clean
gulp.task('clean', function() {
  return del(['./style.css']);
});



// Watch
gulp.task('watch', function() {
  // Watch .scss files
  browserSync.init({
        proxy: localhost,
    	open: true,
    	injectChanges: true,

    });

  gulp.watch('app/sass/**/*.scss', ['styles']);

  // Watch .js files
  gulp.watch('app/js/custom/**/*.js', ['scripts_custom']);

   
  gulp.watch('**/*.php').on('change', function () {
    browserSync.reload();
  });
   gulp.watch('**/*.php').on('change', function () {
    browserSync.reload();
  });
  // Watch image files
  //gulp.watch('src/images/**/*', ['images']);

  // 


  // Watch any files in dist/, reload on change
  gulp.watch(['./']).on('change', browserSync.reload);

});
// Default task
gulp.task('default', ['watch']);

var gulp = require('gulp');
var sass = require('gulp-sass');
var cleanCSS  = require('gulp-clean-css');
var uglify = require('gulp-uglify');
var babel = require('gulp-babel');

gulp.task('css', function () { //設定一個可以 compile scss to css 的功能並壓縮檔案
	return gulp.src('./app.scss')
	.pipe(sass().on('error', sass.logError))
	.pipe(cleanCSS())
	.pipe(gulp.dest('./build'))
});

gulp.task('script', function () { //將 JS 檔轉成 ES5 語法再壓縮
	return gulp.src('./app.js')
	.pipe(babel())
	.pipe(uglify())
	.pipe(gulp.dest('./build'))
});


gulp.task('default', gulp.series('css', 'script'));


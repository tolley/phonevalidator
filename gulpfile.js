// Require our modules
var gulp = require( 'gulp' );
var sass = require( 'gulp-sass' );
var concat = require( 'gulp-concat');
var minifyCSS = require( 'gulp-minify-css' );
var watch = require( 'gulp-watch' );
var rename = require( 'gulp-rename' );

// The list of all scss files that we care about
var scssFiles = [
	'./src/scss/styles.scss'
];

// Process the scss file and creates min.css
gulp.task( 'scss', function() {
	return gulp.src( scssFiles )
		.pipe( sass() )
		.pipe( concat( 'styles.css' ) )
		.pipe( minifyCSS() )
		.pipe( gulp.dest( './public/' ) );
} ); 

// Watch the scss files and reminify when one is modified
gulp.task( 'watch-scss', function() {
	return gulp.watch( scssFiles, gulp.series( "scss" ) );
} );

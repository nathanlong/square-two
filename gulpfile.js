var gulp       = require('gulp');
var concat     = require('gulp-concat');
var libsass    = require('gulp-sass');
var autoprefix = require('gulp-autoprefixer');
var uglify     = require('gulp-uglify');
var notify     = require('gulp-notify');
var changed    = require('gulp-changed');

// Asset Handling - SCSS and JS
// ---------------------------------------------------------------------------

// Compile top-level sass and autoprefix that jounce
gulp.task('sass', function () {
	// Load any top-level sass file, let sass handle importing partials
	return gulp.src('assets/source/sass/*.scss')
	.pipe(libsass({
		outputStyle: 'nested', // only supports nested or compressed
		sourceComments: 'normal'
	}))
	// Prevent sass from stopping on errors
	.on('error', handleErrors)
	// Autoprefixer defaults to > 1%, last 2 versions, Firefox ESR, Opera 12.1 browser support
	.pipe(autoprefix())
	.pipe(gulp.dest('assets/build/css'));
});

// Compile top-level sass and compress it like whoa
gulp.task('sass-build', function () {
	return gulp.src('assets/source/sass/*.scss')
	.pipe(libsass({
		outputStyle: 'compressed', // only supports nested or compressed
	}))
	// Prevent sass from stopping on errors
	.on('error', handleErrors)
	// Autoprefixer defaults to > 1%, last 2 versions, Firefox ESR, Opera 12.1 browser support
	.pipe(autoprefix())
	.pipe(gulp.dest('assets/build/css'));
});

// Concatenates all js into a single file
gulp.task('concat', function(){
	return gulp.src([
		// Load bootstrap js in order
		'./assets/source/vendor/bootstrap/js/transition.js',
		'./assets/source/vendor/bootstrap/js/alert.js',
		'./assets/source/vendor/bootstrap/js/button.js',
		'./assets/source/vendor/bootstrap/js/carousel.js',
		'./assets/source/vendor/bootstrap/js/collapse.js',
		'./assets/source/vendor/bootstrap/js/dropdown.js',
		'./assets/source/vendor/bootstrap/js/modal.js',
		'./assets/source/vendor/bootstrap/js/tooltip.js',
		'./assets/source/vendor/bootstrap/js/popover.js',
		'./assets/source/vendor/bootstrap/js/scrollspy.js',
		'./assets/source/vendor/bootstrap/js/tab.js',
		'./assets/source/vendor/bootstrap/js/affix.js',

		// Other plugins. Load more here as necessary
		'./assets/source/vendor/flickity/flickity.pkgd.min.js',
		'./assets/source/vendor/packery.pkgd.min.js',

		// Turn on wildcard selector? Grabs any js file in source/vendor root
		// './assets/source/vendor/*.js',

		// Load all custom js last
		'./assets/source/js/main.js',
	])
	.pipe(concat('all.js'))
	.pipe(gulp.dest('./assets/build/js/'));
});

// Static Assets
// ---------------------------------------------------------------------------

// Move static files only if there are changes
gulp.task('static', ['vendor-fonts'], function(){
	return gulp.src('assets/static/**/*')
	.pipe(changed('assets/build'))
	// extra pipes can go here if needed, ie image compression
	.pipe(gulp.dest('assets/build'));
});

// Move fonts not in static folder
gulp.task('vendor-fonts', function(){
	return gulp.src([
		'./assets/source/vendor/bootstrap/fonts/*',
		// Place any other vendor fonts here:
		// './assets/source/vendor/...',
	])
	.pipe(changed('assets/build/fonts'))
	.pipe(gulp.dest('assets/build/fonts'));
});


// Watch and Build Functions
// ---------------------------------------------------------------------------

// Compiles compressed version of sass, then builds and minifies all js
gulp.task('build', ['concat','sass-build', 'static'], function(){
	return gulp.src('assets/build/js/*.js')
	.pipe(uglify())
	.pipe(gulp.dest('assets/build/js'));
});

// Watch for changes, recompile sass and js
gulp.task('watch', function(){
	gulp.watch('assets/source/sass/**/*.scss', ['sass']);
	gulp.watch('assets/source/js/**/*.js', ['concat']);
	gulp.watch('assets/static/**/*', ['static']);
});

// Default Task
// Build everything and kick off the watch
// ---------------------------------------------------------------------------

// Build everything and kick off the watch
gulp.task('default', ['concat', 'sass', 'static', 'watch']);

// Error Handling
// ---------------------------------------------------------------------------

function handleErrors(){
	var args = Array.prototype.slice.call(arguments);

	// Send error to notification center with gulp-notify
	notify.onError({
		title: "Compile Error",
		message: "<%= error.message %>"
	}).apply(this, args);

	// Keep gulp from hanging on this task
	this.emit('end');
}

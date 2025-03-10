const gulp = require('gulp');
const concat = require('gulp-concat');
const terser = require('gulp-terser');

// TODO 
const paths = {
    scripts: [
        'node_modules/jquery/dist/jquery.js',
        'node_modules/select2/dist/js/select2.js',
        'node_modules/bootstrap/dist/js/bootstrap.bundle.js',
        'node_modules/@popperjs/core/dist/umd/popper.min.js',
        'node_modules/tippy.js/dist/tippy.umd.min.js',
        'node_modules/inputmask/dist/inputmask.min.js',
        'node_modules/inputmask/dist/jquery.inputmask.min.js'
    ]
};

function js_libs () {
    if (global.additionalBuildFolder) {
        return gulp.src(paths.scripts)
            .pipe(concat('vendor.js'))
            .pipe(terser())
            .pipe(gulp.dest('build/js'))
            .pipe(gulp.dest(`${global.additionalBuildFolder}/js`));
    } else {
        return gulp.src(paths.scripts)
            .pipe(concat('vendor.js'))
            .pipe(terser())
            .pipe(gulp.dest('build/js'));
    }



};

module.exports = () => $.gulp.task("js-libs", js_libs)

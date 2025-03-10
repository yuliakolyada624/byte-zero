module.exports = () =>
  $.gulp.task("htaccess", () => {
    let stream = $.gulp.src("./src/ht.access")
      .pipe(ifenv($.gp.concat(".htaccess")))
      .pipe(ifenv($.gulp.dest("./build/")))

    if (global.additionalBuildFolder) {
      stream = stream.pipe(ifenv($.gulp.dest(global.additionalBuildFolder)))
    }

    return stream
  })

module.exports = () => {
  $.gulp.task("revision", ifenv() ? revision : async () => {
  })
}

function revision() {
  return new Promise(async (resolve) => {
    const mainStream = $.gulp
      .src("./build/**/*.min.{js,css}")
      .pipe($.gp.rev())
      .pipe($.gp.revDeleteOriginal())
      .pipe($.gulp.src("./build/**/*.html"))
      .pipe($.gp.revRewrite())
      .pipe($.gulp.dest("./build"))

    if (global.additionalBuildFolder) {
      const additionalStream = $.gulp
        .src(`${global.additionalBuildFolder}/**/*.min.{js,css}`)
        .pipe($.gp.rev())
        .pipe($.gp.revDeleteOriginal())
        .pipe($.gulp.src("./build/**/*.html"))
        .pipe($.gulp.dest(global.additionalBuildFolder))
        .pipe($.gp.revRewrite())
        .pipe($.gulp.dest(global.additionalBuildFolder))

      return $.merge(mainStream, additionalStream).on("end", () => resolve(true))
    }

    mainStream.on("end", () => resolve(true))
  })
}

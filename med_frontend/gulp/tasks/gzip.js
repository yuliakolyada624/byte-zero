module.exports = () =>
  $.gulp.task("gzip", ifenv() ? gzip : async () => { });

function gzip() {
  return new Promise(async (resolve) => {
    let mainStream = $.gulp
      .src("./build/**/*.min.{css,js}")
      .pipe(ifenv($.gp.zopfliGreen()))
      .pipe(ifenv($.gulp.dest("./build/")));

    if (global.additionalBuildFolder) {
      const additionalStream = $.gulp
        .src(`${global.additionalBuildFolder}/**/*.min.{css,js}`)
        .pipe(ifenv($.gp.zopfliGreen()))
        .pipe(ifenv($.gulp.dest(global.additionalBuildFolder)));

      return $.merge(mainStream, additionalStream).on("end", () => resolve(true));
    }

    mainStream.on("end", () => resolve(true));
  });
}

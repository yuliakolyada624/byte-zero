const resourcesCopy = () => {
  let stream = $.gulp.src("./src/assets/*.*").pipe($.gulp.dest("./build"));

  if (global.additionalBuildFolder) {
    stream = stream.pipe($.gulp.dest(global.additionalBuildFolder));
  }

  return stream;
};

module.exports = () => {
  $.gulp.task("resources:copy", resourcesCopy);
};

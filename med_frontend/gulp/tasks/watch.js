module.exports = () =>
  $.gulp.task("watch", () => {
    $.gulp.watch("./src/views/**/*.twig", $.gulp.series("twig", "inject:assets", "inject:menu-global"))

    $.gulp.watch("./src/json/**/*.json", $.gulp.series("twig"))

    $.gulp.watch("./src/assets/pwa/service-worker.js", $.gulp.series("pwa:sw", "twig"))

    $.gulp.watch(`./src/assets/scss/**/*.scss`, $.gulp.series("styles"))

    $.gulp.watch("./src/assets/{icon,svg}/*.svg", $.gulp.series("svg"))

    $.gulp.watch("./src/assets/js/**/*.js", $.gulp.series("scripts"))

    $.gulp.watch(
      ["./src/web/video/**/*.*", "./src/web/music/**/*.*", "./src/web/docs/**/*.*", `./src/web/img/**/*.${img_format}`],
      $.gulp.series("media")
    )
  })

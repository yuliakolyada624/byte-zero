const variables = require("./gulp/gulpfile.variables")
variables(global, __dirname)

// Build task
$.gulp.task(
  "build",
  $.gulp.series(
    "clean",
    $.gulp.parallel("twig", "scripts", "js-libs", "fonts:copy", "svg", "media", "htaccess", "json"),
    "styles",
    "resources:copy",
    "pwa:sw",
    "pwa:configs",
    "pwa:favicons",
    "media:tiny",
    "revision",
    "inject:assets",
    "gzip",
  ),
)

// Dev task
$.gulp.task("dev", $.gulp.series("build", "inject:menu-global", $.gulp.parallel("watch", "serve")))

// Default task
$.gulp.task("default", $.gulp.series("build", "inject:menu-global", $.gulp.parallel("watch", "serve")))

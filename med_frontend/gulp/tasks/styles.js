module.exports = () => $.gulp.task("styles", scss)
const plugins = [require("autoprefixer")]

function scss() {
  const sass = require("gulp-sass")(require("sass"))

  let stream = $.gulp
    .src("./src/assets/scss/main.scss")
    .pipe($.gp.sourcemaps.init())
    .pipe(
      $.gp.sassVariables({
        $ViewPort: ViewPort
      })
    )
    .pipe(
      sass({
        includePaths: ["node_modules"],
        errLogToConsole: true
      })
    )
    .pipe($.gp.postcss(plugins))
    .pipe(ifenv($.gp.plumber(), "development"))
    .pipe($.gp.concat("app.css"))
    .pipe($.gulp.dest("./build/css/"))

  if (global.additionalBuildFolder) {
    stream = stream.pipe($.gulp.dest(`${global.additionalBuildFolder}/css/`))
  }

  stream = stream
    .pipe(ifenv($.gp.csscomb()))
    .pipe(ifenv($.gp.postcss()))
    .pipe($.gp.concat("app.min.css"))
    .pipe($.gp.sourcemaps.write("../maps"))
    .pipe($.gulp.dest("./build/css/"))

  if (global.additionalBuildFolder) {
    stream = stream.pipe($.gulp.dest(`${global.additionalBuildFolder}/css/`))
  }

  return stream.pipe(
    ifenv(
      $.browserSync.reload({
        stream: true
      }),
      "development"
    )
  )
}

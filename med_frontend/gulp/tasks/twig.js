const path = require("path")

module.exports = () => $.gulp.task("twig", twig_template)

function twig_template() {
  const getCurrentPage = ({ path: filePath }) => {
    const fileBaseName = path.basename(filePath)
    const extNameRegExp = new RegExp(path.extname(filePath))

    return fileBaseName.replace(extNameRegExp, "")
  }

  const throwData = (data) => {
    const currentPage = getCurrentPage(data)

    return { currentPage, prod }
  }

  const functions = [
    {
      name: "json",
      func: function(fileName) {
        return JSON.parse($.fs.readFileSync(path.join(__dirname, "..", "..", "src", "json", `${fileName}.json`), "utf8"))
      }
    },
    {
      name: "auto",
      func: function(fileName) {
        return require(path.join(__dirname, "..", "..", "src", "auto", `${fileName}.json`))
      }
    }
  ]

  let mainStream = $.gulp
    .src("./src/views/**/{*.page.twig,index.twig}")
    .pipe(ifenv($.gp.plumber(), "development"))
    .pipe($.gp.data(throwData))
    .pipe($.gp.twig({
      base: "./src/views",
      functions
    }))
    .on(
      "error",
      $.gp.notify.onError((error) => {
        return {
          title: "Twig",
          message: error
        }
      })
    )
    .pipe(
      ifenv(
        $.gp.htmlmin({
          collapseWhitespace: true
          // removeComments: prod
        })
      )
    )
    .pipe($.gp.flatten())
    .pipe($.gulp.dest((file) => {
      file.path = file.path.replace(/\.page/, "")

      return "./build"
    }))
    .pipe(
      ifenv(
        $.browserSync.reload({
          stream: true
        }),
        "development"
      )
    )

  if (global.additionalBuildFolder) {
    mainStream = mainStream.pipe($.gulp.dest(global.additionalBuildFolder))
  }

  return mainStream
}

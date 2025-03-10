const devices = require("../create-pwa/devices")

const injectTransformHandle = (filepath) => filepath.match(/[^\\/]+\.[^\\/]+$/)[0]

module.exports = () => {
  $.gulp.task("inject:assets", async () => {
    const mainStream = $.gulp
      .src("./build/**/*.html")
      .pipe(
        $.gp.inject($.gulp.src("./build/launch-screens/launch-screen.png", { read: false, allowEmpty: true }), {
          starttag: "<!-- inject:splash screens -->",
          endtag: "<!-- endinject:splash screens -->",
          transform: (filepath) => {
            const splashScreenTags = devices.map((device) => {
              return `<link rel="apple-touch-startup-image" media="(device-width: ${device.width / device.ratio
                }px) and (device-height: ${device.height / device.ratio}px) and (-webkit-device-pixel-ratio: ${device.ratio
                })" href="./launch-screens/launch-screen-${device.width}x${device.height}.png" />`
            })

            return splashScreenTags.join("")
          }
        })
      )
      .pipe(
        ifenv(
          $.gp.inject($.gulp.src("./src/assets/fonts/*.woff2", { read: false }), {
            starttag: "<!-- inject:font preload -->",
            endtag: "<!-- endinject:font preload -->",
            transform: (filepath) => {
              const fileName = injectTransformHandle(filepath)

              return `<link rel="preload" href="fonts/${fileName}" as="font" type="font/woff2" crossorigin="" />`
            }
          })
        )
      )
      .pipe($.gulp.dest("./build"))

    if (global.additionalBuildFolder) {
      const additionalStream = $.gulp
        .src(`${global.additionalBuildFolder}/**/*.html`)
        .pipe(
          $.gp.inject($.gulp.src(`${global.additionalBuildFolder}/launch-screens/launch-screen.png`, { read: false, allowEmpty: true }), {
            starttag: "<!-- inject:splash screens -->",
            endtag: "<!-- endinject:splash screens -->",
            transform: (filepath) => {
              const splashScreenTags = devices.map((device) => {
                return `<link rel="apple-touch-startup-image" media="(device-width: ${device.width / device.ratio
                  }px) and (device-height: ${device.height / device.ratio}px) and (-webkit-device-pixel-ratio: ${device.ratio
                  })" href="./launch-screens/launch-screen-${device.width}x${device.height}.png" />`
              })

              return splashScreenTags.join("")
            }
          })
        )
        .pipe(
          ifenv(
            $.gp.inject($.gulp.src("./src/assets/fonts/*.woff2", { read: false }), {
              starttag: "<!-- inject:font preload -->",
              endtag: "<!-- endinject:font preload -->",
              transform: (filepath) => {
                const fileName = injectTransformHandle(filepath)

                return `<link rel="preload" href="fonts/${fileName}" as="font" type="font/woff2" crossorigin="" />`
              }
            })
          )
        )
        .pipe($.gulp.dest(global.additionalBuildFolder))

      return $.merge(mainStream, additionalStream)
    }

    return mainStream
  })

  $.gulp.task("inject:menu-global", async () => {
    const injectMenu = (sourcePath, destPath) => {
      return $.gulp
        .src(sourcePath, { allowEmpty: true })  // Adding allowEmpty option here
        .pipe(
          ifenv(
            $.gp.inject($.gulp.src("./build/**/*.html"), {
              starttag: "{\"menuLink\": {",
              endtag: "}}",
              transform: function (filepath, file, i, length) {
                let filepaths = filepath.replace(/build(\/)/, "")
                let file_name = filepath.match(/[^\\/]+\.[^\\/]+$/)[0].split(".")[0]

                return `"${i + 1}. ${file_name.replace(file_name[0], file_name[0].toUpperCase())}": ".${filepaths}"${i + 1 < length ? "," : ""}`
              }
            }),
            "development"
          )
        )
        .pipe(ifenv($.gulp.dest(destPath), "development"))
    }

    const globalMenuMain = injectMenu("./src/auto/menuGlobal.json", "./src/auto/")

    if (global.additionalBuildFolder) {
      const globalMenuAdditional = injectMenu(`${global.additionalBuildFolder}/auto/menuGlobal.json`, `${global.additionalBuildFolder}/auto/`)
      return $.merge(globalMenuMain, globalMenuAdditional)
    }

    return globalMenuMain
  })
}

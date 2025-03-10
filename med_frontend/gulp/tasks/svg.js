module.exports = () =>
  $.gulp.task("svg", () => {
    let svg_sprite = $.gulp
      .src("./src/assets/icon/*.svg")
      .pipe($.gp.changed("./build/icon/"))
      .pipe(
        $.gp.svgmin({
          cwd: "./gulp"
        })
      )
      .pipe(
        $.gp.cheerio({
          run: ($) => {
            $("[fill]").removeAttr("fill")
            $("[stroke]").removeAttr("stroke")
            $("[style]").removeAttr("style")
          },
          parserOptions: { xmlMode: true }
        })
      )
      .pipe($.gp.replace("&gt;", ">"))
      .pipe(
        $.gp.svgSprite({
          mode: {
            stack: {
              sprite: "../icons/icons.svg",
              example: true
            }
          }
        })
      )
      .pipe($.gulp.dest("./build/icon/"))

    if (global.additionalBuildFolder) {
      svg_sprite = svg_sprite.pipe($.gulp.dest(`${global.additionalBuildFolder}/icon/`))
    }

    let svg = $.gulp
      .src("./src/assets/svg/**/*.svg")
      .pipe($.gp.changed("./build/svg/"))
      .pipe($.gp.svgmin())
      .pipe($.gulp.dest("./build/svg/"))

    if (global.additionalBuildFolder) {
      svg = svg.pipe($.gulp.dest(`${global.additionalBuildFolder}/svg/`))
    }

    return $.merge(svg_sprite, svg)
  })

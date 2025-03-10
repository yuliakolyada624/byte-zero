const { rollup } = require("rollup")
const { babel } = require("@rollup/plugin-babel")
const { nodeResolve } = require("@rollup/plugin-node-resolve")
const commonjs = require("@rollup/plugin-commonjs")
const terser = require("@rollup/plugin-terser")
const json = require("@rollup/plugin-json")

async function rollup_js() {
  try {
    const bundle = await rollup({
      input: "src/assets/js/main.js",
      plugins: [
        nodeResolve(),
        commonjs(),
        babel({
          babelHelpers: "bundled",
          presets: [
            ...["@babel/preset-env"],
          ],
        }),
        json(),
      ],
    })

    await bundle.write({
      file: "build/js/main.js",
      format: "iife",
      plugins: [
        /**
         * Minify by production mode
         * */
        ...(prod ? [terser()] : []),
      ],
    })

    if (global.additionalBuildFolder) {
      await bundle.write({
        file: `${global.additionalBuildFolder}/js/main.js`,
        format: "iife",
        plugins: [
          /**
           * Minify by production mode
           * */
          ...(prod ? [terser()] : []),
        ],
      })
    }

    if (!prod) {
      $.browserSync.reload()
    }
  } catch (error) {
    console.error(error)
  }
}

function webpack() {
  const webpackStream = require("webpack-stream")

  let stream = $.gulp
    .src("./src/assets/js/main.js")
    .pipe(webpackStream(require("../../webpack.config")))
    .pipe($.gulp.dest("./build/js"))

  if (global.additionalBuildFolder) {
    stream = stream.pipe($.gulp.dest(`${global.additionalBuildFolder}/js`))
  }

  return stream.pipe(
    ifenv(
      $.browserSync.reload({
        stream: true,
      }),
      "development"
    )
  )
}

module.exports = () => $.gulp.task("scripts", rollup_js)

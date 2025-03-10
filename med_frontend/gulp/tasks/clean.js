module.exports = () =>
  $.gulp.task("clean", () => {
    const pathsToDelete = [
      './build/**',
      '!./build',
      '!./build/img'
    ]

    if (global.additionalBuildFolder) {
      pathsToDelete.push(
        `${global.additionalBuildFolder}/**`,
        `!${global.additionalBuildFolder}`,
        `!${global.additionalBuildFolder}/img`
      )
    }

    return $.del(pathsToDelete, {force: true})
  })

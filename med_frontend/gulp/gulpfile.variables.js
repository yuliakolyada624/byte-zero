const config = require("./gulpfile.config")
const ifEnv = require("gulp-if-env")
const yargs = require('yargs').argv

module.exports = (global, projectFolderPath) => {
  global.$ = {
    path: {
      tasks: require("./tasks/index.js")
    },
    gulp: require("gulp"),
    merge: require("merge-stream"),
    del: require("del"),
    fs: require("fs"),
    browserSync: require("browser-sync").create(),
    gp: require("gulp-load-plugins")()
  }

  global.projectFolderPath = projectFolderPath
  global.prod = ifEnv("production")
  global.json = (path) => JSON.parse($.fs.readFileSync(`./src/json/${path}.json`, "utf8"))
  global.ifenv = (fn, type = "production") => ifEnv(type, fn) // production || development
  
  global.additionalBuildFolder = yargs.additionBuildFolder

  for (const [key, value] of Object.entries(config)) {
    global[key] = value
  }

  $.path.tasks.forEach((taskPath) => require(taskPath)())
}

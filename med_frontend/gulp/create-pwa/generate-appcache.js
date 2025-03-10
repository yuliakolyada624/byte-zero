const helpers = require("./helpers")
const fs = require("fs")
const path = require("path")
const through = require("through2")

const generateAppcache = () => {
  return through.obj((file, encoding, callback) => {
    const manifest = require(path.join(__dirname, "..", "..", "build", "manifest.json"));
    const projectName = manifest.name.replace(/\s/, '-').toLowerCase();
    file.path = path.join(__dirname, "..", "..", "build", `${projectName}.appcache`)

    file.contents = new Buffer.from(
      `
      CACHE MANIFEST
      CACHE:
      # Offline cache v2

      # See below for example
      # on how to add files to cache:

      # Favicons
      ${helpers.appleTouchIconFiles.join("\n")}
      ${helpers.faviconFiles.join("\n")}
      ${helpers.msTileFiles.join("\n")}

      # App Icons
      ${helpers.iconFiles.join("\n")}

      # App Launch screens
      ${helpers.launchScreenFiles.join("\n")}
      `)

    callback(null, file)
  })
}

module.exports = generateAppcache

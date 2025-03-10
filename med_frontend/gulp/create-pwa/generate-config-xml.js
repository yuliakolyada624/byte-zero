const through = require("through2")
const path = require("path")

const generateConfigXml = () => {
  return through.obj((file, encoding, callback) => {
    const manifest = JSON.parse(file.contents.toString())
    file.path = path.join(__dirname, "..", "..", "build", "config.xml")

    file.contents = new Buffer.from(`<?xml version="1.0" encoding="utf-8"?>
      <browserconfig>
        <msapplication>
          <tile>
            <square70x70logo src="./favicons/mstile-70x70.png"/>
            <square150x150logo src="./favicons/mstile-150x150.png"/>
            <wide310x150logo src="./favicons/mstile-310x150.png"/>
            <square310x310logo src="./favicons/mstile-310x310.png"/>
            <TileColor>${manifest.theme_color}</TileColor>
          </tile>
        </msapplication>
      </browserconfig>`)

    callback(null, file)
  })
}

module.exports = generateConfigXml;

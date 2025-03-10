const screens = require("./screen-sizes")
const path = require("path")
const fs = require("fs")
const through = require("through2")

const manifestTemplate = {
  name: "Company name",
  start_url: ".",
  display: "fullscreen",
  background_color: "#000000",
  theme_color: "#000000",
  description: "Company descr",
  related_applications: [],
  permissions: ["gcm"],
  gcm_sender_id: "",
  gcm_user_visible_only: true,
  lang: "en",
  dir: "ltr",
  short_name: "Short name",
  orientation: "all",
  scope: "/"
}

const icons = screens.icons.map((size) => ({
  src: `favicons/icon-${size}.png`,
  sizes: size,
  type: "image/png",
  purpose: "any maskable"
}))

const generateManifest = (buildPath) => {
  return through.obj(async (file, encoding, callback) => {
    const manifest = JSON.parse(file.contents.toString())
    manifestTemplate.icons = icons

    file.contents = new Buffer.from(JSON.stringify({ ...manifestTemplate, ...manifest }))

    callback(null, file)
  })
}

module.exports = generateManifest

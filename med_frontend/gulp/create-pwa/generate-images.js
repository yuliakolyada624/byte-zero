const screens = require('./screen-sizes');
const path = require('path');
const through = require('through2');
const sharp = require('sharp');
const ico = require('sharp-ico');

// ===== Helpers
const generateIco = async (file, dest) => {
  await ico.sharpsToIco([sharp(file)], dest + '/favicon.ico').catch((err) => {
    console.error(err);
  });
};

const generateImages = (file, folder, sizes, prefix) => {
  for (const size of sizes) {
    const [width, height] = size.split('x');

    sharp(file).resize(Number(width), Number(height)).png().toFile(`${folder}/${prefix}-${size}.png`);
  }
};

// ===== Gulp plugins
const faviconIcoGenerate = (buildPath) => {
  return through.obj((file, encoding, callback) => {
    const icon = path.resolve(file.path);

    generateIco(icon, buildPath);
    callback(null, file);
  });
};

const faviconGenerate = (buildPath) => {
  return through.obj((file, encoding, callback) => {
    const icon = path.resolve(file.path);

    generateImages(icon, buildPath, screens.icons, 'icon');
    generateImages(icon, buildPath, screens.favicons, 'favicon');
    generateImages(icon, buildPath, screens.msTiles, 'ms-tile');
    generateImages(icon, buildPath, screens.icons, 'apple-touch-icon');

    callback(null, file);
  });
};

const launchScreensGenerate = (buildPath) => {
  return through.obj((file, encoding, callback) => {
    const launch = path.resolve(file.path);

    generateImages(launch, buildPath, screens.launchScreens, 'launch-screen');

    callback(null, file);
  });
};

module.exports = {
  faviconGenerate,
  launchScreensGenerate,
  faviconIcoGenerate
};

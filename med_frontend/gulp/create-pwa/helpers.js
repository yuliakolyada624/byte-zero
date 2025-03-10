const screens = require('./screen-sizes');

const iconFiles = screens.icons.map((size) => `./favicons/icon-${size}.png`);
const launchScreenFiles = screens.launchScreens.map((size) => `./launch-screens/launch-screen-${size}.png`);
const appleTouchIconFiles = screens.appleTouchIcons.map((size) => `./favicons/apple-touch-icon-${size}.png`);
const faviconFiles = screens.favicons.map((size) => `./favicons/favicon-${size}.png`);
const msTileFiles = screens.msTiles.map((size) => `./favicons/ms-tile-${size}.png`);

module.exports = {
  iconFiles,
  launchScreenFiles,
  appleTouchIconFiles,
  faviconFiles,
  msTileFiles
};

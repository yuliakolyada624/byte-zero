const fs = require('fs');
const path = require('path');

module.exports = () => {
  $.gulp.task("media", async () => {
    const srcImgFiles = await getImgFiles("./src/web/img");
    const webpFiles = await getWebpFiles(srcImgFiles);
    const filteredWebpFiles = webpFiles.filter(file => file !== null);

    const videoTask = $.gulp
      .src("./src/web/video/**/*.*")
      .pipe($.gp.changed("./build/video/"))
      .pipe($.gulp.dest("./build/video/"));

    if (global.additionalBuildFolder) {
      videoTask.pipe($.gulp.dest(`${global.additionalBuildFolder}/video/`));
    }

    const musicTask = $.gulp
      .src("./src/web/music/**/*.*")
      .pipe($.gp.changed("./build/music/"))
      .pipe($.gulp.dest("./build/music/"));

    if (global.additionalBuildFolder) {
      musicTask.pipe($.gulp.dest(`${global.additionalBuildFolder}/music/`));
    }

    const docsTask = $.gulp
      .src("./src/web/docs/**/*.*")
      .pipe($.gp.changed("./build/docs/"))
      .pipe($.gulp.dest("./build/docs/"));

    if (global.additionalBuildFolder) {
      docsTask.pipe($.gulp.dest(`${global.additionalBuildFolder}/docs/`));
    }

    const imgTask = $.gulp
      .src(`./src/web/img/**/*.${img_format}`)
      .pipe($.gp.changed("./build/img/"))
      .pipe(
        ifenv(
          $.gp.imagemin([
            $.gp.imagemin.gifsicle({ interlaced: true }),
            $.gp.imagemin.mozjpeg({ quality: 75, progressive: true }),
            $.gp.imagemin.optipng({ optimizationLevel: 5 }),
          ])
        )
      )
      .pipe($.gulp.dest("./build/img/"));

    if (global.additionalBuildFolder) {
      imgTask.pipe($.gulp.dest(`${global.additionalBuildFolder}/img/`));
    }

    const mediaWebpTask = () => {
      return $.gulp.src(`./src/web/img/**/*.${img_format}`)
        .pipe($.gp.webp({ quality: 90 }))
        .pipe($.gulp.dest("./build/img/"))
        .pipe($.gulp.dest(global.additionalBuildFolder ? `${global.additionalBuildFolder}/img/` : "./build/img/"));
    };

    if (filteredWebpFiles.length < srcImgFiles.length) {
      return $.merge(videoTask, musicTask, docsTask, imgTask, mediaWebpTask());
    } else {
      return $.merge(videoTask, musicTask, docsTask, imgTask);
    }
  });

  $.gulp.task("media:tiny", ifenv() ? tiny_png : async () => { });
}

function tiny_png() {
  return new Promise(async (resolve) => {
    const tinyPngStream = $.gulp
      .src(`./build/img/**/*.{png,jpg,jpeg,PNG,JPG,JPEG}`)
      .pipe(ifenv($.gp.tinypng(tiny_png_key)))
      .pipe(ifenv($.gulp.dest("./build/img/")));

    if (global.additionalBuildFolder) {
      tinyPngStream.pipe(ifenv($.gulp.dest(`${global.additionalBuildFolder}/img/`)));
    }

    tinyPngStream.on("end", () => resolve(true));
  });
}

async function getWebpFiles(imgFiles) {
  const webpFiles = await Promise.all(imgFiles.map(async file => {
    const relativeFilePath = path.relative(path.join(__dirname, '../../', 'src/web/img/'), file);
    const directoryPath = path.dirname(relativeFilePath);
    const webpPath = path.join(__dirname, '../../', 'build', 'img', directoryPath, path.basename(file, path.extname(file)) + ".webp");
    return new Promise(resolve => {
      fs.access(webpPath, fs.constants.F_OK, err => {
        if (err) {
          resolve(null);
        } else {
          resolve(webpPath);
        }
      });
    });
  }));
  return webpFiles;
}

async function getImgFiles(dir) {
  const imgFiles = [];
  const files = await fs.promises.readdir(dir);
  for (const file of files) {
    const filePath = path.join(dir, file);
    const stat = await fs.promises.stat(filePath);
    if (stat.isDirectory()) {
      const subFiles = await getImgFiles(filePath);
      imgFiles.push(...subFiles);
    } else if (/\.(png|jpe?g)$/i.test(file)) {
      imgFiles.push(filePath);
    }
  }
  return imgFiles;
}
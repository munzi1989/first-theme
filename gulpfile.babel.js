import gulp from 'gulp'
import yargs from 'yargs'
const sass = require('gulp-sass')(require('sass'))
import cleanCSS from 'gulp-clean-css'
import gulpIf from 'gulp-if'
import sourcemaps from 'gulp-sourcemaps'
import imagemin from 'gulp-imagemin'
import del from 'del'
import webpack from 'webpack-stream'

const PRODUCTION = yargs.argv.prod

console.log('!!!!  PRODUCTION = ', PRODUCTION)

// define paths from src to dist folders in an object for ease of use
const paths = {
  styles: {
    src: ['src/assets/scss/bundle.scss', 'src/assets/scss/admin.scss'],
    dest: 'dist/assets/css',
  },
  images: {
    src: 'src/assets/images/**/*.{jpg, jpeg, svg, png, gif}',
    dest: 'dist/assets/images',
  },
  scripts: {
    src: 'src/assets/js/bundle.js',
    dest: 'dist/assets/js',
  },
  other: {
    src: [
      'src/assets/**/*',
      '!src/assets/{images, js, scss}',
      '!src/assets/{images, js, scss}/**/*',
    ],
    dest: 'dist/assets',
  },
}

// gulp styles to generate CSS from SCSS if in production
export const styles = (done) => {
  // can pass array instead of string for src if you want to run multiple files
  return gulp
    .src(paths.styles.src)
    .pipe(gulpIf(!PRODUCTION, sourcemaps.init()))
    .pipe(sass().on('error', sass.logError))
    .pipe(gulpIf(PRODUCTION, cleanCSS({ compatibility: 'ie8' })))
    .pipe(gulpIf(!PRODUCTION, sourcemaps.write()))
    .pipe(gulp.dest(paths.styles.dest))
}
// minify images if able
export const images = () => {
  return gulp
    .src(paths.images.src)
    .pipe(gulpIf(PRODUCTION, imagemin()))
    .pipe(gulp.dest(paths.images.dest))
}

// update styles on SCSS file update
export const watch = () => {
  gulp.watch('src/assets/scss/**/*.scss', styles)
  gulp.watch(paths.images.src, images)
  gulp.watch(paths.other.src, copySrc)
}
// copy src folder into dist folder
export const copySrc = () => {
  return gulp.src(paths.other.src).pipe(gulp.dest(paths.other.dest))
}
// delete dist folder
export const clean = (done) => del(['dist'])

// minify js scripts and use babel to be compatible w/ ie8
export const scripts = () => {
  return gulp
    .src(paths.scripts.src)
    .pipe(
      webpack({
        module: {
          rules: [
            {
              test: /\.js%/,
              use: {
                loader: 'babel-loader',
                options: {
                  presets: ['@babel/preset-env'],
                },
              },
            },
          ],
        },
        // names the output file
        output: {
          filename: 'bundle.js',
        },
        devtool: !PRODUCTION ? 'inline-source-map' : false,
        // production mode uglifies by default
        mode: PRODUCTION ? 'production' : 'development',
      }),
    )
    .pipe(gulp.dest(paths.scripts.dest))
}

// automated tasks for dev and build
export const dev = gulp.series(
  clean,
  gulp.parallel(styles, images, copySrc),
  watch,
)

export const build = gulp.series(clean, gulp.parallel(styles, images, copySrc))

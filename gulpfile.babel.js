import gulp from 'gulp'
import yargs from 'yargs'
const sass = require('gulp-sass')(require('sass'))
import cleanCSS from 'gulp-clean-css'
import gulpIf from 'gulp-if'
import sourcemaps from 'gulp-sourcemaps'
import imagemin from 'gulp-imagemin'
import del from 'del'
import webpack from 'webpack-stream'
import named from 'vinyl-named'
import browserSync from 'browser-sync'
import zip from 'gulp-zip'
import replace from 'gulp-replace'
import info from './package.json'

// to create server for browser sync
const server = browserSync.create()
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
    src: ['src/assets/js/bundle.js', 'src/assets/js/admin.js'],
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
  package: {
    src: [
      '**/*',
      '!.vscode',
      '!node_modules',
      '!node_modules{,/**}',
      '!packaged{,/**}',
      '!src/{,**}',
      '!.babelrc',
      '!.gitignore',
      '!gulpfile.babel.js',
      '!package.json',
      '!package-lock.json',
    ],
    dest: 'packaged',
  },
}
// Start browsersync server
export const serve = (done) => {
  server.init({
    proxy: 'http://localhost/WP-Course/first-theme/',
  })
  done()
}
// reolad browser
const reload = (done) => {
  server.reload()
  done()
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
    .pipe(server.stream())
}
// minify images if able
export const images = () => {
  return gulp
    .src(paths.images.src)
    .pipe(gulpIf(PRODUCTION, imagemin()))
    .pipe(gulp.dest(paths.images.dest))
}
// update all watched on change
export const watch = () => {
  gulp.watch('src/assets/scss/**/*.scss', styles)
  gulp.watch('src/assets/js/**/*.js', gulp.series(scripts, reload))
  gulp.watch('**/*.php', reload)
  gulp.watch(paths.images.src, gulp.series(images, reload))
  gulp.watch(paths.other.src, gulp.series(copySrc, reload))
  console.log('Watching for changes...')
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
    .pipe(named())
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
          filename: '[name].js',
        },
        // assign jQuery as external to use as npm dependency in bundle.js
        externals: {
          jquery: 'jQuery',
        },
        // if !PRODUCTION don't include soruce map
        devtool: !PRODUCTION ? 'inline-source-map' : false,
        // production mode uglifies JS by default
        mode: PRODUCTION ? 'production' : 'development',
      }),
    )
    .pipe(gulp.dest(paths.scripts.dest))
}

// DEVELoPMENT
// automated tasks for dev and build
export const dev = gulp.series(
  clean,
  gulp.parallel(styles, images, scripts, copySrc),
  serve,
  watch,
)

// PRODUCTION
// distribute src files to dist folder- uglify, minimize resources, prepare to zip
export const build = gulp.series(
  clean,
  gulp.parallel(styles, images, scripts, copySrc),
)


// bundles all resources into zip folder for
export const compress = () => {
  return gulp
    .src(paths.package.src)
    .pipe(replace('_themename', `${info.name}`))
    .pipe(zip(`${info.name}.zip`))
    .pipe(gulp.dest(paths.package.dest))
}

// PACKAGE/BUNDLE PROJECT-FINISHED
export const bundle = gulp.series(build, compress)

import gulp from 'gulp';
import yargs from 'yargs';
var sass = require('gulp-sass')(require('sass'));
import cleanCSS from 'gulp-clean-css';
import gulpIf from 'gulp-if';
import sourcemaps from 'gulp-sourcemaps';
import imagemin from 'gulp-imagemin';

const PRODUCTION = yargs.argv.prod;

console.log('!!!!  PRODUCTION = ', PRODUCTION);

const paths = {
  styles: {
    src: ['src/assets/scss/bundle.scss', 'src/assets/scss/admin.scss'],
    dest: 'dist/assets/css',
  },
  images: {
    src: 'src/assets/images/**/*.{jpg, jpeg, svg, png, gif}',
    dest: 'dist/assets/images',
  },
  other: {
		src: ['src/assets/**/*','!src/assets/{images,js,scss}', '!src/assets/{images,js,scss}/**/*'],
		dest: 'dist/assets'
	}
}


export const styles = (done) => {
  // can pass array instead of string for src if you want to run multiple files
  return gulp.src(paths.styles.src)
    .pipe(gulpIf(!PRODUCTION, sourcemaps.init()))
    .pipe(sass().on('error', sass.logError))
    .pipe(gulpIf(PRODUCTION, cleanCSS({ compatibility: 'ie8' })))
    .pipe(gulpIf(!PRODUCTION, sourcemaps.write()))
    .pipe(gulp.dest(paths.styles.dest))
}

export const images = () => {
  return gulp.src(paths.images.src)
    .pipe(gulpIf(PRODUCTION, imagemin()))
    .pipe(gulp.dest(paths.images.dest))
}

export const watch = () => {
  gulp.watch('src/assets/scss/**/*.scss', styles)
}

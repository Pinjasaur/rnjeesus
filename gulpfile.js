var gulp    = require("gulp"),
    plugins = require("gulp-load-plugins")(),
    server  = require("browser-sync").create(),
    pkg     = require("./package.json"),
    config  = {
      autoprefixer: {
        browsers: ["last 2 versions"]
      },
      browserSync: {
        proxy: {
       target: "http://localhost/",
     },
        notify: false,
        // Create a tunnel (if using `--tunnel`) with a subdomain of:
        // 1. the first "chunk" of the package.json `name`
        // 2. a random 6-character string appended to it
        // Note: needs to be lowercased alphanumerics
        tunnel: plugins.util.env.tunnel ?
                (pkg.name.trim().toLowerCase().split(/[^a-zA-Z0-9]/g)[0] + // [1]
                Math.random().toString(36).substr(2, 6)) :                 // [2]
                false,
      }
    };

// Build the Sass
gulp.task("sass", function() {
  return gulp.src("sass/*.scss")
    .pipe(plugins.plumber())
    .pipe(plugins.sass.sync())
    .pipe(plugins.autoprefixer(config.autoprefixer))
    .pipe(gulp.dest("css/"))
    .pipe(server.reload({ stream: true }));
});

// Spin up server with live-reloading
gulp.task("serve", function() {
  server.init(config.browserSync);
  gulp.watch("sass/**/*.scss", ["sass"]);
  gulp.watch("js/**/*.js", server.reload);
  gulp.watch("*.{php,html}", server.reload)
});

gulp.task("default", ["serve"]);

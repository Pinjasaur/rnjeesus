var gulp    = require("gulp"),
    plugins = require("gulp-load-plugins")(),
    server  = require("browser-sync").create(),
    pkg     = require("./package.json"),
    production = (plugins.util.env.prod ||plugins.util.env.production) ? true : false,
    config  = {
      sass: {
        outputStyle: (production) ? "compressed" : "expanded"
      },
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
    .pipe(plugins.if(!production, plugins.sourcemaps.init()))
    .pipe(plugins.sass.sync(config.sass))
    .pipe(plugins.autoprefixer(config.autoprefixer))
    .pipe(plugins.if(!production, plugins.sourcemaps.write(".")))
    .pipe(gulp.dest("css/"))
    .pipe(server.stream({ match: "**/*.css" }));
});

// Build
gulp.task("build", ["sass"]);

// Spin up server
gulp.task("server", ["build"], function(done) {
  server.init(config.browserSync, done);
})

// Serve content and watch for changes
gulp.task("serve", ["server"], function() {
  gulp.watch("sass/**/*.scss",  ["sass"]);
  gulp.watch("js/**/*.js",      server.reload);
  gulp.watch("**/*.{php,html}", server.reload)
});

gulp.task("default", ["serve"]);

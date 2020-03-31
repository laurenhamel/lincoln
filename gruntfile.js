// Export configurations.
module.exports = (grunt) => {

  // Load dependencies.
  const pkg = require('./package.json');
  const composer = require('./composer.json');
  const path = require('path');

  // Initialize configurations.
  grunt.initConfig({
    pkg,
    composer,
    env: {
      dev: {
        NODE_ENV: 'development'
      },
      prod: {
        NODE_ENV: 'production'
      }
    },
    watch: {
      js: {
        files: [
          'assets/js/**/*.js',
        ],
        tasks: [
          'build:dev:js'
        ]
      },
      scss: {
        files: [
          'assets/scss/**/*.scss'
        ],
        tasks: [
          'build:dev:scss'
        ]
      },
      app: {
        files: [
          'app/**/*.php',
          'assets/**/*.twig',
          'assets/**/*.json'
        ],
        tasks: [
          'build:dev:app'
        ]
      },
      config: {
        options: {
          reload: true
        },
        files: [
          'gruntfile.json',
          'package.json',
          'composer.json',
          '.babelrc',
          '.browserlistrc',
          '.jshintrc',
          '.aliasrc',
          'webpack.config.js',
          '.htaccess'
        ],
        tasks: [
          'build:dev'
        ]
      }
    },
    jshint: {
      main: {
        options: {
          jshintrc: true
        },
        src: ['assets/js/**/*.js']
      }
    },
    phplint: {
      main: {
        src: ['app/**/*.php']
      }
    },
    browserify: {
      main: {
        options: {
          transform: [
            ['envify', { NODE_ENV: process.env.NODE_ENV }],
            'require-globify',
            ['aliasify', grunt.file.readJSON('.aliasrc')],
            ['babelify', {
              global: true,
              babelrc: true,
              configFile: path.resolve('.babelrc')
            }]
          ]
        },
        files: {
          'public/js/bundle.js': ['assets/js/**/*.js']
        }
      }
    },
    uglify: {
      main: {
        files: [{
          expand: true,
          cwd: 'public/js',
          src: [
            '**/*.js',
            '!**/*.min.js'
          ],
          dest: 'public/js',
          ext: '.min.js'
        }]
      }
    },
    'dart-sass': {
      main: {
        options: {
          outputStyle: process.env.NODE_ENV === 'development' ? 'expanded' : 'compressed',
          includePaths: ['node_modules'],
          importer: [
            function (url, prev) {

              // Get the path's parts.
              const parts = url.split('/');

              // Create list of shorthands for folder names.
              const shorthands = {
                '@config': 'assets/scss/config',
                '@vends': 'assets/scss/vends',
                '@core': 'assets/scss/core',
                '@comps': 'assets/scss/comps',
                '@utils': 'assets/scss/utils'
              };

              // Ignore paths without a shorthand.
              if( !Object.keys(shorthands).includes(parts[0]) ) return null;

              // Otherwise, expand the the shorthand in the path.
              return {
                file: `${shorthands[parts[0]]}/${parts.slice(1).join('/')}`
              };

            }
          ]
        },
        files: [{
          expand: true,
          cwd: 'assets/scss',
          src: ['*.scss'],
          dest: 'public/css',
          ext: '.css'
        }]
      }
    },
    postcss: {
      main: {
        options: {
          processors: [
            require('autoprefixer')
          ]
        },
        src: ['public/css/**/*.css']
      }
    },
    cssmin: {
      main: {
        files: [{
          expand: true,
          cwd: 'public/css',
          src: [
            '**/*.css',
            '!**/*.min.css'
          ],
          dest: 'public/css',
          ext: '.min.css'
        }]
      }
    },
    clean: ['public'],
    copy: {
      main: {
        files: [
          {
            expand: true,
            cwd: 'assets/partials',
            src: ['**/*.twig'],
            dest: 'public/partials'
          },
          {
            expand: true,
            cwd: 'assets/data',
            src: ['**/*.json'],
            dest: 'public/data'
          },
          {
            expand: true,
            cwd: 'assets/images',
            src: ['**/*'],
            dest: 'public/images'
          },
          {
            expand: true,
            cwd: 'node_modules/@fortawesome/fontawesome-free/',
            src: ['webfonts/**'],
            dest: 'public'
          }
        ]
      }
    }
  });

  // Load tasks.
  require('load-grunt-tasks')(grunt);

  // Register tasks.
  grunt.registerTask('default', ['dev']);
  grunt.registerTask('build:dev:js', [
    'jshint',
    'browserify'
  ]);
  grunt.registerTask('build:dev:scss', [
    'dart-sass',
    'postcss'
  ]);
  grunt.registerTask('build:dev:app', [
    'phplint',
    'copy'
  ]);
  grunt.registerTask('build:dev', [
    'env:dev',
    'clean',
    'build:dev:js',
    'build:dev:scss',
    'build:dev:app'
  ]);
  grunt.registerTask('build:prod:js', [
    'browserify',
    'uglify'
  ]);
  grunt.registerTask('build:prod:scss', [
    'dart-sass',
    'postcss',
    'cssmin'
  ]);
  grunt.registerTask('build:prod:app', [
    'copy'
  ]);
  grunt.registerTask('build:prod', [
    'env:prod',
    'clean',
    'build:prod:js',
    'build:prod:scss',
    'build:prod:app'
  ]);
  grunt.registerTask('dev', [
    'build:dev',
    'watch'
  ]);
  grunt.registerTask('build', [
    'build:prod'
  ]);
  grunt.registerTask('prod', [
    'build:prod'
  ]);

};

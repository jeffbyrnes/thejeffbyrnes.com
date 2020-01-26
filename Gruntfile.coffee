module.exports = (grunt) ->
  "use strict"

  # Load all grunt tasks
  require("jit-grunt") grunt

  # Project configuration
  grunt.initConfig
    pkg: grunt.file.readJSON("package.json")

    # Constants
    version: "<%= pkg.version %>"
    name: "<%= pkg.name %>"
    publicDir: "docs"
    sourceStyleDir: "<%= publicDir %>/_scss"
    releaseStyleDir: "<%= publicDir %>/css"

    # Delete generated files
    clean: ["<%= releaseStyleDir %>"]

    # Lint Coffee using CoffeeLint
    coffeelint:
      options:
        'max_line_length':
          'level': 'ignore'
      gruntfile: ["Gruntfile.coffee"]

    # Compile Sass into CSS
    compass:
      prod:
        options:
          environment: "production"
          outputStyle: "compressed"
          noLineComments: true

      dev:
        options:
          environment: "development"
          outputStyle: "expanded"
          debugInfo: true
          # Doesn't work in current Compass alpha
          # sourcemap: true

    # Watch files for changes
    watch:
      gruntfile:
        files: "<%= coffeelint.gruntfile %>"
        tasks: ["coffeelint"]

      compass:
        files: ["<%= sourceStyleDir %>/*.scss"]
        tasks: ["compass:dev"]

      livereload:
        options:
          livereload: true

        files: ["<%= releaseStyleDir %>/*.css", "<%= publicDir %>/**/*.php"]


  # Default task.
  grunt.registerTask "default", ["compass:dev"]
  grunt.registerTask "release", ["clean", "compass:prod"]
  grunt.util.linefeed = "\n"

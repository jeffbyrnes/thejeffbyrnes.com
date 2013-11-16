module.exports = (grunt) ->
  "use strict"

  # Load all grunt tasks
  require("matchdep").filterDev("grunt-*").forEach grunt.loadNpmTasks

  # Project configuration
  grunt.initConfig
    pkg: grunt.file.readJSON("package.json")

    # Constants
    version: "<%= pkg.version %>"
    name: "<%= pkg.name %>"
    publicDir: "public/"
    sourceStyleDir: "<%= publicDir %>/_scss"
    releaseStyleDir: "<%= publicDir %>/css"
    sourceJSDir: "<%= publicDir %>/lib"
    releaseJSDir: "<%= publicDir %>/js"

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
          environment: "prod"

      dev:
        options:
          environment: "dev"

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

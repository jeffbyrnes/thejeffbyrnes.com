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
    publicDir: "public"
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

    # Concatenate JS files
    concat:
      options:
        banner: "<%= banner %>"
        stripBanners: true

      dist:
        src: [
          # Follows Bootstrap's makefile for the order
          "shared/bower_components/modernizr/modernizr.js",
          "<%= sourceJSDir %>/plugins.js",
          "<%= sourceJSDir %>/main.js"
        ]
        dest: "<%= releaseJSDir %>/main.js"

    # Minify JS w/ Uglify.js
    uglify:
      options:
        banner: "<%= banner %>"

      dist:
        src: "<%= concat.dist.dest %>"
        dest: "<%= releaseJSDir %>/main.js"

    # Lint JS using JSHint
    jshint:
      lib:
        src: "<%= sourceJSDir %>/**/*.js"

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

      js:
        files: "<%= jshint.lib.src %>"
        tasks: ["js"]

      compass:
        files: ["<%= sourceStyleDir %>/*.scss"]
        tasks: ["compass:dev"]

      livereload:
        options:
          livereload: true

        files: ["<%= releaseStyleDir %>/*.css", "<%= publicDir %>/**/*.php"]


  # Default task.
  grunt.registerTask "default", ["js", "compass:dev"]
  grunt.registerTask "release", ["clean", "js", "uglify", "compass:prod"]
  grunt.registerTask "js", ["jshint", "concat"]
  grunt.util.linefeed = "\n"

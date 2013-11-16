# Require any additional compass plugins here.

# Set this to the root of your project when deployed:
http_path = "/"
css_dir = "public/css"
sass_dir = "public/_scss"
images_dir = "public/img"
javascripts_dir = "public/js"

# Set various options depending on environment
if environment != :prod
  # Dev output is expanded & has debug info & line comments
  sass_options = {:debug_info => true}
  output_style = :expanded
else
  # Prod output is compressed & has no comments etc.
  line_comments = false
  output_style = :compressed
end

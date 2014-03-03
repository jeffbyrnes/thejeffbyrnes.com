# Load DSL and Setup Up Stages
require 'capistrano/setup'

# Includes default deployment tasks
require 'capistrano/deploy'

# Need NPM to use Grunt
require 'capistrano/npm'

# Include Grunt tasks
require 'capistrano/grunt'

# Use Datadog to notice deployments
require 'capistrano/datadog'

# Loads custom tasks from `lib/capistrano/tasks' if you have any defined.
Dir.glob('lib/capistrano/tasks/*.cap').each { |r| import r }

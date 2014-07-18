# Load DSL and Setup Up Stages
require 'capistrano/setup'

# Includes default deployment tasks
require 'capistrano/deploy'

# Use deploy-tagger to tag releases
require 'cap-deploy-tagger'

# Use Datadog to notice deployments
require 'capistrano/datadog'

# Loads custom tasks from `lib/capistrano/tasks' if you have any defined.
Dir.glob('lib/capistrano/tasks/*.cap').each { |r| import r }

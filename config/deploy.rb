set :application, 'thejeffbyrnes.com'
set :repo_url, 'git@bitbucket.org:jeffbyrnes/thejeffbyrnes.com.git'
set :scm, :git

# ask :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }

server 'thejeffbyrnes.com', user: 'deploy', roles: %w{web app db}



set :keep_releases, 5

# Ensure Grunt runs the `grunt release` command
set :grunt_tasks, 'release'

namespace :deploy do

  after :finishing, 'deploy:cleanup'

end


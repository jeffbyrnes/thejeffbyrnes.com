set :application, 'thejeffbyrnes.com'
set :repo_url, 'git@bitbucket.org:jeffbyrnes/thejeffbyrnes.com.git'

# ask :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }

server 'thejeffbyrnes.com', user: 'ec2-user', roles: %w{web app db}

# you can set custom ssh options
# it's possible to pass any option but you need to keep in mind that net/ssh understand limited list of options
# you can see them in [net/ssh documentation](http://net-ssh.github.io/net-ssh/classes/Net/SSH.html#method-c-start)
# set it globally
set :ssh_options, { forward_agent: true }

set :deploy_to, "/srv/#{application}"
set :scm, :git

set :datadog_api_key, "3a10dbd29a7e52f9f75c76b7951564a7"

# set :format, :pretty
# set :log_level, :debug
set :pty, true

# set :linked_files, %w{config/database.yml}
# set :linked_dirs, %w{bin log tmp/pids tmp/cache tmp/sockets vendor/bundle public/system}

# set :default_env, { path: "/opt/ruby/bin:$PATH" }
set :keep_releases, 5

# Ensure Grunt runs the `grunt release` command
set :grunt_tasks, 'release'

namespace :deploy do

  after :finishing, 'deploy:cleanup'

end

# before :updated, 'grunt'
# before :updated, 'build'
# before :updated, 'shared:make_shared_dir'
# before :updated, 'shared:make_symlinks'

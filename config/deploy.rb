# replace these with your server's information
set :domain,  "thejeffbyrnes.com"
set :user,    "ec2-user"

# name this the same thing as the directory on your server
set :application, "thejeffbyrnes.com"

# or use a hosted repository
set :repository, "ssh://git@bitbucket.org/jeffbyrnes/jeffbyrn.es.git"

server "#{domain}", :app, :web, :db, :primary => true

set :deploy_via, :copy
set :copy_exclude, [
  ".DS_Store",
  ".git",
  ".gitignore",
  ".editorconfig",
  ".gitattributes",
  ".sass_cache",
  "Capfile",
  "config",
  "icon.png",
  "README.md"
]

set :scm, :git
set :branch, "master"

# Set where to deploy files
set :deploy_to, "/srv/#{application}"

# Point symlink to public folder
set :release_path, "#{releases_path}/#{release_name}"

# Don't use sudo for operations
set :use_sudo, false

# Number of releases to keep
set :keep_releases, 5

# Tells Capistrano to create a local version of the repo and use that to run deploys.
# This means it doesn't do a full clone each time
set :deploy_via, :remote_cache
# Must be set for the password prompt from git to work
default_run_options[:pty] = true

ssh_options[:forward_agent] = true
ssh_options[:paranoid]      = false

# this tells capistrano what to do when you deploy
namespace :deploy do
  desc <<-DESC
  A macro-task that updates the code and fixes the symlink.
  DESC
  task :default do
    transaction do
      update_code
      create_symlink
    end
  end

  task :update_code, :except => { :no_release => true } do
    on_rollback { run "rm -rf #{release_path}; true" }
    strategy.deploy!
  end

  task :after_deploy do
    cleanup
  end
end

namespace :shared do
  task :make_shared_dir do
    run "if [ ! -d #{shared_path}/files ]; then mkdir #{shared_path}/files; fi"
  end
  task :make_symlinks do
    run "if [ ! -h #{release_path}/shared ]; then ln -s #{shared_path}/files/ #{release_path}/shared; fi"
    run "for p in `find -L #{release_path}/public -type l`; do t=`readlink $p | grep -o 'shared/.*$'`; mkdir -p #{release_path}/public/$t; sudo chown apache:ec2-user #{release_path}/public/$t; done"
  end
end

after "deploy:update_code", "shared:make_shared_dir"
after "deploy:update_code", "shared:make_symlinks"


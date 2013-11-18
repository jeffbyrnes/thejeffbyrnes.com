# encoding: UTF-8

# replace these with your server's information
set :domain,  'thejeffbyrnes.com'
set :user,    'ec2-user'

# name this the same thing as the directory on your server
set :application, 'thejeffbyrnes.com'

# or use a hosted repository
set :repository, 'ssh://git@bitbucket.org/jeffbyrnes/jeffbyrn.es.git'

server "#{domain}", :app, :web, :db, primary: true

set :deploy_via, :copy
set :copy_exclude, [
  '.DS_Store',
  '.git',
  '.gitignore',
  '.editorconfig',
  '.gitattributes',
  '.sass_cache',
  'Capfile',
  'config',
  'config.rb',
  'icon.png',
  'Gruntfile.js',
  'README.md',
  'node_modules'
]

set :scm, :git
set :branch, 'master'

# Set where to deploy files
set :deploy_to, "/srv/#{application}"

# Point symlink to public folder
set :release_path, "#{releases_path}/#{release_name}"

# Don't use sudo for operations
set :use_sudo, false

# Number of releases to keep
set :keep_releases, 5

# Tells Capistrano to create a local version of the repo and use that
# to run deploys. Ensures it doesn't do a full clone each time
set :deploy_via, :remote_cache

# Must be set for the password prompt from git to work
default_run_options[:pty] = true

ssh_options[:forward_agent] = true
ssh_options[:paranoid]      = false

# this tells capistrano what to do when you deploy
namespace :deploy do
  desc 'A macro-task that updates the code and fixes the symlink.'
  task :default do
    transaction do
      update_code
      create_symlink
    end
  end

  task :update_code, except: { no_release: true } do
    on_rollback { run "rm -rf #{release_path}; true" }
    strategy.deploy!
  end

  task :after_deploy do
    cleanup
  end
end

namespace :build do
  desc 'Handle all compilation, minification, and deployment of assets'
  task :default do
    # optional way to skip build & just upload current assets to the servers
    skip_build = fetch(:skip_build, false)

    build unless skip_build
    upload_build
  end

  desc 'Wrapper command for `grunt release`'
  task :build, roles: :web, except: { no_release: true } do
    # Build site using Grunt.js
    run_locally('grunt release')
  end

  desc 'Uploads compiled release'
  task :upload_build, roles: :web, except: { no_release: true } do
    asset_dirs = ['public/css', 'public/js']
    skip_build = fetch(:skip_build, false)

    logger.debug 'Uploading compiled release'
    asset_dirs.each do |dir|
      logger.debug "trying to upload assets from ./#{dir}/ -> #{latest_release}/#{dir}/"

      upload("#{dir}", "#{latest_release}/", via: :scp, recursive: true)
    end
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

after 'deploy:update_code', 'build'
after 'deploy:update_code', 'shared:make_shared_dir'
after 'deploy:update_code', 'shared:make_symlinks'

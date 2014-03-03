set :application, 'thejeffbyrnes.com'
set :repo_url, 'git@bitbucket.org:jeffbyrnes/thejeffbyrnes.com.git'
set :scm, :git

server 'thejeffbyrnes.com', user: 'deploy', roles: %w{web app db}

set :datadog_api_key, '3a10dbd29a7e52f9f75c76b7951564a7'

set :linked_dirs, %w{public/.flickr-cache node_modules}

set :keep_releases, 5

# Ensure Grunt runs the `grunt release` command
set :grunt_tasks, 'release'


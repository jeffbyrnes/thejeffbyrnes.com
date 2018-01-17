set :application, 'thejeffbyrnes.com'
set :repo_url, 'git@bitbucket.org:jeffbyrnes/thejeffbyrnes.com.git'

server 'aws-jb', user: 'deploy', roles: %w(web app db)

set :datadog_api_key, '3a10dbd29a7e52f9f75c76b7951564a7'

set :linked_dirs, %w(public/.flickr-cache)

set :cloudflare_options,
    domain: 'thejeffbyrnes.com',
    email: 'thejeffbyrnes@gmail.com',
    api_key: ENV['CLOUDFLARE_TOKEN']

before 'deploy:finished', 'grunt:default'
after 'deploy:finished', 'cloudflare:cache:purge'

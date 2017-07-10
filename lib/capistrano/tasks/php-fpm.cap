namespace :php_fpm do
  desc 'Reload PHP-FPM (requires sudo access to the service)'
  task :reload do
    on roles(:all) do
      execute 'sudo systemctl reload php7.0-fpm'
    end
  end
end

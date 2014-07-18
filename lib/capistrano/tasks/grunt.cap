namespace :grunt do
  task default: :asset_rev

  desc 'Build the app for release'
  task :build do
    run_locally do
      execute :grunt, '--no-color', 'release'
      set :grunt_timestamp, Time.new.strftime('%Y%m%d%H%M')
    end
  end

  desc 'Upload the built assets'
  task upload: :'grunt:build' do
    on roles(:all) do
      execute :mkdir, "#{release_path}/public/css"

      %w(error style).each do |file|
        info "Uploading #{release_path}/public/css/#{file}.css"
        upload!(
          "./public/css/#{file}.css",
          "#{release_path}/public/css/#{file}.#{fetch(:grunt_timestamp)}.css"
        )
      end
    end
  end

  desc 'Rev the timestamp'
  task asset_rev: :'grunt:upload' do
    on roles(:all) do
      within release_path do
        execute(
          :sed,
          '-i',
          '-e',
          "s/style.css/style.#{fetch(:grunt_timestamp)}.css/",
          'public/index.php'
        )

        %w(
          401-auth
          403-forbidden
          404
          500-internal
          503-unavailable
        ).each do |error_file|
          execute(
            :sed,
            '-i',
            '-e',
            "s/error.css/error.#{fetch(:grunt_timestamp)}.css/",
            "public/errors/#{error_file}.html"
          )
        end
      end
    end
  end
end

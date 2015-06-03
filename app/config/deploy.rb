set :application, "my_project"
set :domain,      "208.118.63.59"
set :deploy_to,   "/var/www/my_project"
set :app_path,    "app"

set :repository,  "git@github.com:my_project.io/my_project.git"
set :scm,         :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`
set :deploy_via, :copy
set :dump_assetic_assets, true
set :use_composer, true
set :model_manager, "doctrine"
set :share_files,  ["app/config/parameters.yml"]
set :user, "nahuamel"
#set :shared_children, [app_path + "/logs", web_path+"/uploads", "vendor", app_path+"/sessions"]
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set  :keep_releases,  3

# Be more verbose by uncommenting the following line
 logger.level = Logger::MAX_LEVEL
 ssh_options[:forward_agent]=true
 after "deploy:update", "deploy:cleanup"
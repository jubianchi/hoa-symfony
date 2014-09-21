default['hoa_symfony']['app_name'] = nil

app_name = node['hoa_symfony']['app_name']

default[app_name]['root'] = "/var/www/#{app_name}"
default[app_name]['webroot'] = "#{node[app_name]['root']}/web"
default[app_name]['controller'] = 'app.php'
default[app_name]['server_name'] = app_name
default[app_name]['fpm_pool'] = 'www'

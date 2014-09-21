template '/etc/nginx/sites-available/hoa-symfony' do
    source 'nginx.conf.erb'
    owner 'root'
    group 'root'
    mode '0755'
    notifies :run, 'execute[nginx_enable_site]', :immediately
    notifies :restart, 'service[nginx]', :delayed
end

execute 'nginx_enable_site' do
    command 'nxensite hoa-symfony'
end

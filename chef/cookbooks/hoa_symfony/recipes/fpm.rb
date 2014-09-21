template '/etc/init.d/php-fpm' do
    source 'init.d.erb'
    owner 'root'
    group 'root'
    mode '0755'
end

directory node['php-fpm']['conf_dir'] do
    recursive true
end

service 'php-fpm' do
  supports :start => true, :stop => true, :restart => true, :reload => true
  action [ :enable ]
end

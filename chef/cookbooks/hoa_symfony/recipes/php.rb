template '/etc/php5/conf.d/date.ini' do
    source 'php_cfg.ini.erb'
    variables(
        :directive => 'date.timezone',
        :value => 'Europe/Paris'
    )
end

execute 'pecl install intl' do
    not_if 'php -m | grep intl'
end

template '/etc/php5/conf.d/intl.ini' do
    source 'php_cfg.ini.erb'
    variables(
        :directive => 'extension',
        :value => 'intl.so'
    )
end

execute 'pecl install ZendOpcache-beta' do
    not_if 'php -m | grep OPcache'
end

template '/etc/php5/conf.d/opcache.ini' do
    source 'php_cfg.ini.erb'
    variables(
        :directive => 'zend_extension',
        :value => 'opcache.so'
    )
end

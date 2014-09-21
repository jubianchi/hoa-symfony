execute 'pecl install xdebug' do
    not_if 'php -m | grep Xdebug'
end

template '/etc/php5/conf.d/xdebug.ini' do
    source 'php_cfg.ini.erb'
    variables(
        :directive => 'zend_extension',
        :value => 'xdebug.so'
    )
end

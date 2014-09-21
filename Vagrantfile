VAGRANTFILE_API_VERSION = '2'

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.ssh.forward_agent = true

  if Vagrant.has_plugin?('vagrant-hostmanager')
    config.hostmanager.enabled = true
    config.hostmanager.manage_host = true
    config.hostmanager.ignore_private_ip = false
    config.hostmanager.include_offline = true
    config.hostmanager.aliases = %w(hoasf sfhoa)
  end

  if Vagrant.has_plugin?('vagrant-berkshelf')
    config.berkshelf.enabled = true
    config.berkshelf.berksfile_path = './Berksfile'
  end

  if Vagrant.has_plugin?('vagrant-omnibus')
    config.omnibus.chef_version = :latest

    if Vagrant.has_plugin?('vagrant-cachier')
      config.omnibus.cache_packages = true
    end
  end

  if Vagrant.has_plugin?('vagrant-cachier')
    config.cache.scope = :box
    config.cache.enable :apt
    config.cache.enable :gem
  end

  config.vm.box = 'jubianchi/php-55-dev'

  config.vm.hostname = 'hoa-symfony'
  config.vm.network 'private_network', ip: '192.168.33.10'

  config.vm.synced_folder '~/.composer', '/home/vagrant/.composer'
  config.vm.synced_folder 'app/cache', '/vagrant/app/cache', mount_options: ['dmode=777', 'fmode=777']
  config.vm.synced_folder 'app/logs', '/vagrant/app/logs', mount_options: ['dmode=777', 'fmode=777']

  config.vm.provider 'virtualbox' do |vb|
    vb.customize ['modifyvm', :id, '--memory', '1024']
    vb.customize ['modifyvm', :id, '--cpus', '2']
  end

  config.vm.provision 'chef_solo' do |chef|
    unless Vagrant.has_plugin?('vagrant-berkshelf')
        chef.cookbooks_path = ['vendor/cookbooks', 'chef/cookbooks']
    end

    json = JSON.parse(File.read('solo.json'))
    json['php-fpm']['pools'][0]['php_options']['env[SYMFONY_ENV]'] = 'dev'
    json['php-fpm']['pools'][0]['php_options']['env[SYMFONY_DEBUG]'] = 1
    json['etc_environment']['SYMFONY_ENV'] = 'dev'
    json['etc_environment']['SYMFONY_DEBUG'] = 1
    json['hoa-symfony']['root'] = '/vagrant'
    json['hoa-symfony']['server_name'] = 'hoa-symfony hoasf sfhoa'
    json['run_list'] << 'recipe[hoa_symfony::dev]'

    chef.json = json
  end

  config.vm.provision 'shell', inline: 'composer self-update'
  config.vm.provision 'shell', inline: 'cd /vagrant && composer install'
end

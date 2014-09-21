VAGRANTFILE_API_VERSION = '2'

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.ssh.forward_agent = true

  unless Vagrant.has_plugin?('vagrant-hostmanager')
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

  config.vm.provider 'virtualbox' do |vb|
    vb.customize ['modifyvm', :id, '--memory', '1024']
    vb.customize ['modifyvm', :id, '--cpus', '2']
  end

  config.vm.provision 'chef_solo' do |chef|
    unless Vagrant.has_plugin?('vagrant-berkshelf')
        chef.cookbooks_path = 'vendor/cookbooks'
    end

    chef.run_list = JSON.parse(File.read('solo.json'))['run_list']
  end

  config.vm.provision 'shell', inline: 'apt-get install -y libicu48 libicu-dev'
  config.vm.provision 'shell', inline: 'php -m | grep intl || pecl install intl'
  config.vm.provision 'shell', inline: 'echo "extension=/usr/local/lib/php/extensions/no-debug-non-zts-20121212/intl.so" > /etc/php5/conf.d/intl.ini'
  config.vm.provision 'shell', inline: 'echo "date.timezone = Europe/Paris" > /etc/php5/conf.d/date.ini'
  config.vm.provision 'shell', inline: 'echo "SYMFONY_ENV=dev" > /etc/environment'
  config.vm.provision 'shell', inline: 'composer self-update'
  config.vm.provision 'shell', inline: 'cd /vagrant && composer install'
end

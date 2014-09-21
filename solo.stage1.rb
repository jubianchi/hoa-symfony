cookbook_path ['/app/vendor/cookbooks', '/app/chef/cookbooks']
role_path "/vagrant/chef/roles"
role "staging"
json_attribs  'solo.json'

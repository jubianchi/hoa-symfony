name 'staging'
override_attributes "php-fpm" => {
    "pools" => [
        {
            "name" => "www",
            "php_options" => {
                "env[SYMFONY_ENV]" => "staging"
            }
        }
    ]
}
override_attributes "etc_environment" => {
    "SYMFONY_ENV" => "staging"
}

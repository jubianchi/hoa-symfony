<?php
// src/Hoathis/Bundle/DemoBundle/WebSocket/Module/Faker.php

namespace Hoathis\Bundle\DemoBundle\WebSocket\Module;

use Atipik\Hoa\WebSocketBundle\WebSocket\Module\Module;
use Faker\Generator;

class Faker extends Module
{
    function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    public function getSubscribedEvents()
    {
        return array('message' => 'onMessage');
    }

    public function onMessage()
    {
        $bucket = $this->getBucket();
        $data = $bucket->getData();

        if (preg_match('/^faker:\s*(?<generator>[a-z][a-z0-9_]*)/i', $data['message'], $matches)) {
            try {
                $bucket->getSource()->send($this->faker->{$matches['generator']});
            } catch(\Exception $exception) {
                $bucket->getSource()->send($exception->getMessage());
            }
        }
    }
} 

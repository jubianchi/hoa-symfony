<?php
// src/Hoathis/DemoBundle/WebSocket/Module/Faker.php

namespace Hoathis\DemoBundle\WebSocket\Module;

use Atipik\Hoa\WebSocketBundle\WebSocket\Module\Module;
use Symfony\Component\Process\Process;

class Faker extends Module
{
    public function getSubscribedEvents()
    {
        return array('message' => 'onMessage');
    }

    public function onMessage()
    {
        $bucket = $this->getBucket();
        $data = $bucket->getData();

        if (preg_match('/^faker:\s*(?<generator>[a-z][a-z0-9_]*)/i', $data['message'], $matches)) {
            $faker = $this->container->get('hoathis.demo.faker');

            try {
                $bucket->getSource()->send($faker->{$matches['generator']});
            } catch(\Exception $exception) {
                $bucket->getSource()->send($exception->getMessage());
            }
        }
    }
} 
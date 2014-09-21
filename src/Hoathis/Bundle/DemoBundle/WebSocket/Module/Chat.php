<?php
// src/Hoathis/Bundle/DemoBundle/WebSocket/Module/Chat.php

namespace Hoathis\Bundle\DemoBundle\WebSocket\Module;

use Atipik\Hoa\WebSocketBundle\WebSocket\Module\Module;

class Chat extends Module
{
    public function getSubscribedEvents()
    {
        return array(
            'open' => 'onOpen',
            'message' => 'onMessage',
        );
    }

    public function onOpen()
    {
        $this->getServer()->broadcast('Someone joined the room');
    }

    public function onMessage()
    {
        $data = $this->getBucket()->getData();

        $this->getServer()->broadcast($data['message']);
    }
}

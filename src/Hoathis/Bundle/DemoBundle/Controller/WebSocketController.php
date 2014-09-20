<?php

namespace Hoathis\Bundle\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WebSocketController extends Controller
{
    public function indexAction()
    {
        return $this->render(
            'views://WebSocket/index.html.twig',
            array(
                'code_chat' => file_get_contents(__DIR__ . '/../WebSocket/Module/Chat.php'),
                'code_faker' => file_get_contents(__DIR__ . '/../WebSocket/Module/Faker.php')
            )
        );
    }
}

<?php

namespace Hoathis\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WebSocketController extends Controller
{
    public function indexAction()
    {
        if ($this->container->has('profiler'))
        {
            $this->container->get('profiler')->disable();
        }

        return $this->render(
            'HoathisDemoBundle:WebSocket:index.html.twig',
            array(
                'code_chat' => file_get_contents(__DIR__ . '/../WebSocket/Module/Chat.php'),
                'code_faker' => file_get_contents(__DIR__ . '/../WebSocket/Module/Faker.php')
            )
        );
    }
}

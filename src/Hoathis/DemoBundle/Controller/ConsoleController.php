<?php

namespace Hoathis\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConsoleController extends Controller
{
    public function indexAction()
    {
        if ($this->container->has('profiler'))
        {
            $this->container->get('profiler')->disable();
        }

        return $this->render(
            'HoathisDemoBundle:Console:index.html.twig',
            array()
        );
    }
}

<?php

namespace Hoathis\Bundle\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConsoleController extends Controller
{
    public function indexAction()
    {
        return $this->render(
            'views://Console/index.html.twig',
            array()
        );
    }
}

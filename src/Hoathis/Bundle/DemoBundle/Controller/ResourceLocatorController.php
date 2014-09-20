<?php
// src/Hoathis/Bundle/DemoBundle/Controller/ResourceLocatorController.php

namespace Hoathis\Bundle\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ResourceLocatorController extends Controller
{
    public function indexAction()
    {
        return $this->render(
            'views://ResourceLocator/index.html.twig',
            array(
                'code' => file_get_contents(__FILE__),
                'twig' => file_get_contents('views://ResourceLocator/index.html.twig')
            )
        );
    }
}

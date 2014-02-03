<?php
// src/Hoathis/DemoBundle/Controller/BenchController.php

namespace Hoathis\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BenchController extends Controller
{
    public function indexAction()
    {
        $bench = $this->container->get('bench');
        $faker = $this->container->get('hoathis.demo.faker');

        $names = array();
        $addresses = array();

        $addressesMark = $bench->addresses;
        $namesMark = $bench->names;

        for ($i = 1; $i <= 5; $i++) {
            $namesMark->start();
            $nameMark = $bench->{'name #' . $i}->start();

            do {
                $names[$i] = $faker->name;
            } while(strlen($names[$i]) < 30 || false === in_array(substr($names[$i], 0, 1), array('H', 'O', 'A')));

            $nameMark->stop();
            $namesMark->pause(); // Nous mettons le marqueur `names` en pause
                                 // pour ne pas inclure les temps  du marqueur `adresses`

            $addressesMark->start();

            do {
                $addresses[$i] = $faker->address;
            } while(preg_match('/69\d{3}/', $addresses[$i]) === 0);

            $addressesMark->pause();
        }

        $namesMark->stop();     // Nous stoppons les marqueurs mis en pause
        $addressesMark->stop(); // Ceci est facultatif : les marquers en pause
                                // seront aussi présents dans les résultats

        return $this->render(
            'HoathisDemoBundle:Bench:index.html.twig',
            array(
                'names' => $names,
                'addresses' => $addresses,
                'code' => file_get_contents(__FILE__)
            )
        );
    }
}

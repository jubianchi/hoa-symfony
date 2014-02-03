<?php
namespace Hoathis\DemoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DemoBenchCommand extends ContainerAwareCommand
{
    public function __construct($name = null)
    {
        parent::__construct($name ?: 'hoathis:demo:bench');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bench = $this->getContainer()->get('bench.helper');
        $faker = $this->getContainer()->get('hoathis.demo.faker');

        $names = array();
        $addresses = array();
        for ($i = 1; $i <= 5; $i++) {
            $bench->start('names');
            $bench->start('name #' . $i);

            do {
                $names[$i] = $faker->name;
            } while(strlen($names[$i]) < 30);

            $bench->stop('name #' . $i);
            $bench->pause('names');

            $bench->start('addresses');

            do {
                $addresses[$i] = $faker->address;
            } while(preg_match('/69\d{3}/', $addresses[$i]) === 0);

            $bench->pause('addresses');
        }

        $bench->stop('names');
        $bench->stop('addresses');

        $table = $this->getHelper('table');
        $table->setHeaders(array('Name', 'Address'));
        foreach($names as $k => $name) {
            $table->addRow(array($name, str_replace("\n", ' ', $addresses[$k])));
        }

        $bench->start('render');
        $table->render($output);
        $bench->stop('render');

        $bench->summarize($output);
    }
} 
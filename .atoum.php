<?php

use \mageekguy\atoum;

$runner = $script->getRunner();
if (false === $runner->hasReports()) {
    $report = $script->addDefaultReport();

    $report->addField(new atoum\report\fields\runner\atoum\logo());
} else {
    $reports = $runner->getReports();
    $report = current($reports);
}

$script
    ->noCodeCoverageForNamespaces('Symfony')
    ->noCodeCoverageForNamespaces('Hoa')
    ->noCodeCoverageForClasses('Twig_Extension')
;

$runner->addExtension(new \Atoum\PraspelExtension\Manifest());

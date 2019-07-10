<?php

use Noodlehaus\Config;
use DI\ContainerBuilder;

require DOCROOT . 'vendor/autoload.php';

$container = new ContainerBuilder;
$container->addDefinitions(Config::load(DOCROOT . 'config/definitions.php')->all());

return $container->build();
#!/usr/bin/env php
<?php
require __DIR__.'/../vendor/autoload.php';

use Commercetools\Generator\Command\GenerateModelsCommand;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new GenerateModelsCommand());

$application->run();
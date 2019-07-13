#!/usr/bin/env php
<?php

use Sweetchuck\GitStatusTree\Commands\StatusTreeCommand;
use Symfony\Component\Console\Application;

// @todo Detect automatically.
require_once __DIR__ . '/vendor/autoload.php';

$command = new StatusTreeCommand('git-status-tree');
$application = new Application('git-status-tree', '1.0.0');
$application->add($command);
$application->setDefaultCommand($command->getName(), true);
$application->run();

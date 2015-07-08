#!/usr/bin/env php
<?php

require 'vendor/autoload.php';

use HHI\Command\ClassCommand;
use HHI\Command\NamespaceCommand;
use HHI\Command\ExtensionCommand;
use Symfony\Component\Console\Application;

$app = new Application('HHI Generator', '1.0.0');
$app->add(new ClassCommand());
$app->add(new NamespaceCommand());
$app->add(new ExtensionCommand());
$app->run();

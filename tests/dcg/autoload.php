<?php

/**
 * @file
 * Autoloader for DCG tests.
 */

/* @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__ . '/../../vendor/autoload.php';
$loader->addPsr4('DrupalCodeGenerator\\Tests\\', __DIR__);

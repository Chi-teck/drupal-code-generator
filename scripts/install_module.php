#!/usr/bin/env php
<?php declare(strict_types=1);

use DrupalCodeGenerator\BootstrapHandler;

$class_loader = require_once __DIR__ . '/autoload.php';

$module = $argv[1] ?? NULL;
if (!$module) {
  throw new \InvalidArgumentException('Module name is not given');
}

$container = (new BootstrapHandler($class_loader))->bootstrap();
if (!$container->get('module_installer')->install([$module])) {
  throw new \Exception(\sprintf('Unable to install module %s.', $module));
}

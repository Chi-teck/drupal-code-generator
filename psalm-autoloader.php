<?php declare(strict_types = 1);

/** @var \Composer\Autoload\ClassLoader $autoloader */
$autoloader = require __DIR__ . '/vendor/autoload.php';

$modules = [
  'comment',
  'file',
  'node',
  'taxonomy',
  'user',
];
foreach ($modules as $module) {
  $autoloader->addPsr4(
    \sprintf('Drupal\%s\\', $module),
    \sprintf('vendor/drupal/core/modules/%s/src', $module),
  );
}




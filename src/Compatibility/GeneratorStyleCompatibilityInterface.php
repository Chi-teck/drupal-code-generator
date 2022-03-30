<?php declare(strict_types=1);

/**
 * @file
 * Compatibility shim.
 */

namespace DrupalCodeGenerator\Compatibility;

if (\PHP_VERSION_ID >= 80000) {
  \class_alias(
    '\DrupalCodeGenerator\Compatibility\Php8\GeneratorStyleInterface',
    '\DrupalCodeGenerator\Compatibility\GeneratorStyleCompatibilityInterface'
  );
}
else {
  \class_alias(
    '\DrupalCodeGenerator\Compatibility\Php7\GeneratorStyleInterface',
    '\DrupalCodeGenerator\Compatibility\GeneratorStyleCompatibilityInterface'
  );
}

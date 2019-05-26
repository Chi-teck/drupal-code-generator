<?php

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:logger command.
 */
class LoggerTest extends BaseGeneratorTest {

  protected $class = 'Service\Logger';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [FileLog]:' => 'FileLog',
  ];

  protected $fixtures = [
    'foo.services.yml' => __DIR__ . '/_logger.services.yml',
    'src/Logger/FileLog.php' => __DIR__ . '/_logger.php',
  ];

}

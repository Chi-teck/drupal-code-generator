<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for other:dcg-command command.
 */
class DcgCommandTest extends GeneratorTestCase {

  protected $class = 'Other\DcgCommand';

  protected $answers = [
    'custom:example',
    'Some description',
    'example',
  ];

  protected $fixtures = [
    'custom/Example.php' => __DIR__ . '/_dcg_command.php',
  ];

}

<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

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
  protected $target = 'custom/Example.php';
  protected $fixtures = [
    'custom/Example.php' => __DIR__ . '/_dcg_command.php',
  ];

}

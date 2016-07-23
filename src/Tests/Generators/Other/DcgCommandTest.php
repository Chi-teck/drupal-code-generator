<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for other:dcg-command command.
 */
class DcgCommandTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Other\DcgCommand';
    $this->answers = [
      'custom:example',
      'Some description',
      'example',
    ];
    $this->target = 'custom/Example.php';
    $this->fixture = __DIR__ . '/_dcg_command.php';
    parent::setUp();
  }

}

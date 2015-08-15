<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for other:dcg-command command.
 */
class DsgCommandTest extends GeneratorTestCase {

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
    $this->fixture = __DIR__ . '/_Example.php';
    parent::setUp();
  }

}

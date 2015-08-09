<?php

namespace DrupalCodeGenerator\Tests\Drupal_7\Component;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

class TemplatePhpTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->class = 'Drupal_7\Component\TemplatePhp';
    $this->answers = [
      'Example',
      'example',
    ];

    $this->target = 'template.php';
    $this->fixture = __DIR__ . '/_' . $this->target;

    parent::setUp();
  }

}

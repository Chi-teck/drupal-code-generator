<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

class ApacheVirtualHostTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->class = 'Other\ApacheVirtualHost';
    $this->answers = [
      'example.com',
      '/var/www/example.com/public',
    ];
    $this->target = 'example.com.conf';
    $this->fixture = __DIR__ . '/_' . $this->target;
    parent::setUp();
  }

}

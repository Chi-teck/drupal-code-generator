<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\GeneratorTestCase;
use DrupalCodeGenerator\Commands\Other\ApacheVirtualHost;

class ApacheVirtualHostTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->command = new ApacheVirtualHost();
    $this->commandName = 'generate:other:apache-virtual-host';
    $this->answers = [
      'example.com',
      '/var/www/example.com/public',
    ];
    $this->target = 'example.com.conf';
    $this->fixture = __DIR__ . '/_' . $this->target;
    parent::setUp();
  }

}

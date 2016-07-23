<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for other:nginx-virtual-host command.
 */
class NginxVirtualHostTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Other\NginxVirtualHost';
    $this->answers = [
      'example.local',
      '/var/www/example.local/docroot',
    ];
    $this->target = 'example.local';
    $this->fixture = __DIR__ . '/_nginx_virtual_host';
    parent::setUp();
  }

}

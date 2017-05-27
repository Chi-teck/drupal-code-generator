<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for other:apache-virtual-host command.
 */
class ApacheVirtualHostTest extends GeneratorTestCase {

  protected $class = 'Other\ApacheVirtualHost';

  protected $answers = [
    'example.com',
    '/var/www/example.com/public',
  ];

  protected $fixtures = [
    'example.com.conf' => __DIR__ . '/_apache_virtual_host.conf',
  ];

}

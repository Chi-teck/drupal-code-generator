<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for other:apache-virtual-host command.
 */
class ApacheVirtualHostTest extends GeneratorBaseTest {

  protected $class = 'Other\ApacheVirtualHost';

  protected $interaction = [
    'Host name [example.com]:' => 'site.com',
    'Document root [/var/www/site.com/public]:' => '/var/www/example.com/public',
  ];

  protected $fixtures = [
    'site.com.conf' => __DIR__ . '/_apache_virtual_host.conf',
  ];

}

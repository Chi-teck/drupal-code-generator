<?php

namespace DrupalCodeGenerator\Tests\Generator\Other;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:apache-virtual-host command.
 */
class ApacheVirtualHostGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Misc\ApacheVirtualHost';

  protected $interaction = [
    'Host name [example.com]:' => 'site.com',
    'Document root [/var/www/site.com/public]:' => '/var/www/example.com/public',
  ];

  protected $fixtures = [
    'site.com.conf' => __DIR__ . '/_apache_virtual_host.conf',
  ];

}

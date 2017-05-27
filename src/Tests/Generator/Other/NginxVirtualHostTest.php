<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for other:nginx-virtual-host command.
 */
class NginxVirtualHostTest extends GeneratorTestCase {

  protected $class = 'Other\NginxVirtualHost';

  protected $answers = [
    'example.local',
    '/var/www/example.local/docroot',
    'files',
    'files/private',
    'unix:/run/php/php7.0-fpm.sock',
  ];

  protected $fixtures = [
    'example.local' => __DIR__ . '/_nginx_virtual_host',
  ];

}

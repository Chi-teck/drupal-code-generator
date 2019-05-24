<?php

namespace DrupalCodeGenerator\Tests\Generator\Other;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:nginx-virtual-host command.
 */
class NginxVirtualHostGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Misc\NginxVirtualHost';

  protected $interaction = [
    'Server name [example.com]:' => 'example.local',
    'Document root [/var/www/example.local/docroot]:' => '/var/www/example.local/docroot',
    'Public file system path [sites/default/files]:' => 'files',
    'Private file system path:' => 'files/private',
    'Address of a FastCGI server [unix:%socket%]:' => 'unix:/run/php/php7.0-fpm.sock',
  ];

  protected $fixtures = [
    'example.local' => __DIR__ . '/_nginx_virtual_host',
  ];

  /**
   * {@inheritdoc}
   */
  protected function processExpectedDisplay($display) {
    $socket = PHP_MAJOR_VERSION == 5
      ? '/run/php5-fpm.sock'
      : sprintf('/run/php/php%s.%s-fpm.sock', PHP_MAJOR_VERSION, PHP_MINOR_VERSION);
    return str_replace('%socket%', $socket, $display);
  }

}

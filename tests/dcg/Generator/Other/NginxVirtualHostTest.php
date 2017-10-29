<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for other:nginx-virtual-host command.
 */
class NginxVirtualHostTest extends GeneratorBaseTest {

  protected $class = 'Other\NginxVirtualHost';

  protected $interaction = [
    'Server name [example.com]: ' => 'example.local',
    'Document root [/var/www/example.local/docroot]: ' => '/var/www/example.local/docroot',
    'Public file system path [sites/default/files]: ' => 'files',
    'Private file system path: ' => 'files/private',
    'Address of a FastCGI server [unix:/run/php/php7.0-fpm.sock]: ' => 'unix:/run/php/php7.0-fpm.sock',
  ];

  protected $fixtures = [
    'example.local' => __DIR__ . '/_nginx_virtual_host',
  ];

}

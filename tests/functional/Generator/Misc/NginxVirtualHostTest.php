<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Misc;

use DrupalCodeGenerator\Command\Misc\NginxVirtualHost;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests misc:nginx-virtual-host generator.
 */
final class NginxVirtualHostTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_nginx_virtual_host';

  public function testGenerator(): void {

    $user_input = [
      'example.local',
      '/var/www/example.local/docroot',
      'files',
      'files/private',
      'unix:/run/php/php8.2-fpm.sock',
    ];
    $this->execute(NginxVirtualHost::class, $user_input);

    $expected_display = <<< 'TXT'

     Welcome to nginx-virtual-host generator!
    ––––––––––––––––––––––––––––––––––––––––––

     Server name [example.com]:
     ➤ 

     Document root [/var/www/example.local/docroot]:
     ➤ 

     Public file system path [sites/default/files]:
     ➤ 

     Private file system path:
     ➤ 

     Address of a FastCGI server [unix:%socket%]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.local

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.local');
  }

  protected function assertDisplay(string $expected_display): void {
    $socket = \sprintf('/run/php/php%s.%s-fpm.sock', \PHP_MAJOR_VERSION, \PHP_MINOR_VERSION);
    $expected_display = \str_replace('%socket%', $socket, $expected_display);
    parent::assertDisplay($expected_display);
  }

}

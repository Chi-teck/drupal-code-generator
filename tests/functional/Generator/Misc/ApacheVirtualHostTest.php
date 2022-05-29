<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Misc;

use DrupalCodeGenerator\Command\Misc\ApacheVirtualHost;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests misc:apache-virtual-host generator.
 */
final class ApacheVirtualHostTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_apache_virtual_host';

  public function testGenerator(): void {

    $user_input = [
      'site.com',
      '/var/www/example.com/public',
    ];
    $this->execute(new ApacheVirtualHost(), $user_input);

    $expected_display = <<< 'TXT'

     Welcome to apache-virtual-host generator!
    –––––––––––––––––––––––––––––––––––––––––––

     Host name [example.local]:
     ➤ 

     Document root [/var/www/site.com/public]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • site.com-ssl.conf
     • site.com.conf

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('site.com-ssl.conf');
    $this->assertGeneratedFile('site.com.conf');
  }

}

<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Miscellaneous;

use DrupalCodeGenerator\Command\Miscellaneous\ApacheVirtualHost;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests misc:apache-virtual-host generator.
 */
final class ApacheVirtualHostTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_apache_virtual_host';

  /**
   * Test callback.
   */
  public function testGenerator(): void {

    $user_input = [
      'site.com',
      '/var/www/example.com/public',
    ];
    $this->execute(ApacheVirtualHost::class, $user_input);

    $expected_display = <<< 'TXT'

     Welcome to apache-virtual-host generator!
    –––––––––––––––––––––––––––––––––––––––––––

     Host name [example.local]:
     ➤ 

     Document root [{docroot}]:
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

  /**
   * {@inheritdoc}
   */
  protected function assertDisplay(string $expected_display): void {
    parent::assertDisplay(
      \str_replace('{docroot}', \DRUPAL_ROOT, $expected_display),
    );
  }

}

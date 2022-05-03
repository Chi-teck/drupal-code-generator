<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\PhpStormMetadata;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests phpstorm-metadata generator.
 */
final class PhpStormMetadataTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_php_storm_metadata';

  public function testGenerator(): void {

    $this->execute(new PhpStormMetadata(), []);

    $expected_display = <<< 'TXT'

     Welcome to phpstorm-metadata generator!
    –––––––––––––––––––––––––––––––––––––––––

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • .phpstorm.meta.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('.phpstorm.meta.php', 'phpstorm.meta.php');
  }

}

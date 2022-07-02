<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\PluginManager;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin-manager generator.
 */
final class PluginManagerTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_plugin_manager';

  public function testAnnotationDiscovery(): void {
    $input = [
      'foo',
      'Foo',
      'bar',
      'Annotation',
    ];
    $this->execute(PluginManager::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to plugin-manager generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Plugin type [foo]:
     ➤ 

     Discovery type [Annotation]:
      [1] Annotation
      [2] YAML
      [3] Hook
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.services.yml
     • src/BarInterface.php
     • src/BarPluginBase.php
     • src/BarPluginManager.php
     • src/Annotation/Bar.php
     • src/Plugin/Bar/Foo.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_annotation';
    $this->assertGeneratedFile('foo.services.yml');
    $this->assertGeneratedFile('src/BarInterface.php');
    $this->assertGeneratedFile('src/BarPluginBase.php');
    $this->assertGeneratedFile('src/BarPluginManager.php');
    $this->assertGeneratedFile('src/Annotation/Bar.php');
    $this->assertGeneratedFile('src/Plugin/Bar/Foo.php');
  }

  public function testYamlDiscovery(): void {
    $input = [
      'foo',
      'Foo',
      'bar',
      'YAML',
    ];
    $this->execute(PluginManager::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to plugin-manager generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Plugin type [foo]:
     ➤ 

     Discovery type [Annotation]:
      [1] Annotation
      [2] YAML
      [3] Hook
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.bars.yml
     • foo.services.yml
     • src/BarDefault.php
     • src/BarInterface.php
     • src/BarPluginManager.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_yaml';
    $this->assertGeneratedFile('foo.bars.yml');
    $this->assertGeneratedFile('foo.services.yml');
    $this->assertGeneratedFile('src/BarDefault.php');
    $this->assertGeneratedFile('src/BarInterface.php');
    $this->assertGeneratedFile('src/BarPluginManager.php');
  }

  public function testHookDiscovery(): void {
    $input = [
      'foo',
      'Foo',
      'bar',
      'Hook',
    ];
    $this->execute(PluginManager::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to plugin-manager generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Plugin type [foo]:
     ➤ 

     Discovery type [Annotation]:
      [1] Annotation
      [2] YAML
      [3] Hook
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.module
     • foo.services.yml
     • src/BarDefault.php
     • src/BarInterface.php
     • src/BarPluginManager.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_hook';
    $this->assertGeneratedFile('foo.module');
    $this->assertGeneratedFile('foo.services.yml');
    $this->assertGeneratedFile('src/BarDefault.php');
    $this->assertGeneratedFile('src/BarInterface.php');
    $this->assertGeneratedFile('src/BarPluginManager.php');
  }

}

<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Form;

use DrupalCodeGenerator\Command\Form\Config;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests form:config generator.
 */
final class ConfigTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_config';

  public function testGenerator(): void {
    $input = [
      'foo',
      'SettingsForm',
      'Yes',
      'foo.example',
      '/admin/config/content/example',
      'Yo',
      'administer site configuration',
      'Yes',
      'Foo settings',
      'Configure foo.',
      'system.admin_config_content',
    ];
    $this->execute(Config::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to config-form generator!
    –––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [SettingsForm]:
     ➤ 

     Would you like to create a route for this form? [Yes]:
     ➤ 

     Route name [foo.settings]:
     ➤ 

     Route path [/admin/config/system/settings]:
     ➤ 

     Route title [Settings]:
     ➤ 

     Route permission [administer site configuration]:
     ➤ 

     Would you like to create a menu link for this route? [Yes]:
     ➤ 

     Link title [Yo]:
     ➤ 

     Link description:
     ➤ 

     Parent menu item [system.admin_config_content]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.links.menu.yml
     • foo.routing.yml
     • config/schema/foo.schema.yml
     • src/Form/SettingsForm.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.links.menu.yml');
    $this->assertGeneratedFile('foo.routing.yml');
    $this->assertGeneratedFile('config/schema/foo.schema.yml');
    $this->assertGeneratedFile('src/Form/SettingsForm.php');
  }

}

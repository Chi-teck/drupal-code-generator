<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Form;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for form:config command.
 */
final class ConfigTest extends BaseGeneratorTest {

  protected string $class = 'Form\Config';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [SettingsForm]:' => 'SettingsForm',
    'Would you like to create a route for this form? [Yes]:' => 'Yes',
    'Route name [foo.settings]:' => 'foo.example',
    'Route path [/admin/config/system/settings]:' => '/admin/config/content/example',
    'Route title [Settings]:' => 'Yo',
    'Route permission [administer site configuration]:' => 'administer site configuration',
    'Would you like to create a menu link for this route? [Yes]:' => 'Yes',
    'Link title [Yo]:' => 'Foo settings',
    'Link description:' => 'Configure foo.',
    'Parent menu item [system.admin_config_content]:' => 'system.admin_config_content',
  ];

  protected array $fixtures = [
    'foo.links.menu.yml' => '/_config_menu.links.yml',
    'foo.routing.yml' => '/_config_routing.yml',
    'config/schema/foo.schema.yml' => '/_config-schema.yml',
    'src/Form/SettingsForm.php' => '/_config.php',
  ];

}

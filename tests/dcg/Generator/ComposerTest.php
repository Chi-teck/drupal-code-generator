<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator;

use DrupalCodeGenerator\Command\Composer;
use DrupalCodeGenerator\Test\GeneratorTest;

/**
 * Test for composer command.
 */
final class ComposerTest extends GeneratorTest {

  protected string $class = 'Composer';

  protected array $interaction = [
    'Project machine name [%default_machine_name%]:' => 'example',
    'Description:' => 'Example description.',
    'Is this project hosted on drupal.org? [No]:' => 'Yes',
  ];

  protected array $fixtures = [
    'composer.json' => '/_composer.json',
  ];

  protected string $fixtureDir = __DIR__;

  /**
   * Test callback.
   */
  public function testGenerator(): void {

    $user_input = ['drupal/example', 'Some description.', 'drupal-module', 'Yes', 'Yes'];
    $this->execute(new Composer(), $user_input);

    $expected_display = <<< 'TXT'

     Welcome to composer.json generator!
    –––––––––––––––––––––––––––––––––––––

     Project name [drupal/example]:
     ➤ 

     Description:
     ➤ 

     Project type:
      [1] drupal-module
      [2] drupal-custom-module
      [3] drupal-theme
      [4] drupal-custom-theme
      [5] drupal-library
      [6] drupal-profile
      [7] drupal-custom-profile
      [8] drupal-drush
     ➤ 

     Is this project hosted on drupal.org? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • composer.json


    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('composer.json', '_composer.json');
  }

}

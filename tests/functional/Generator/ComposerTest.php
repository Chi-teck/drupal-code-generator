<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\Composer;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests composer generator.
 */
final class ComposerTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_composer';

  public function testGenerator(): void {

    $user_input = ['drupal/example', 'Some description.', 'drupal-module', 'Yes', 'Yes'];
    $this->execute(Composer::class, $user_input);

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

     Is this project hosted on drupal.org? [Yes]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • composer.json

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('composer.json');
  }

}

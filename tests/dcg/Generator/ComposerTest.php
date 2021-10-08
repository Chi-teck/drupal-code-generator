<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for composer command.
 */
final class ComposerTest extends BaseGeneratorTest {

  protected string $class = 'Composer';

  protected array $interaction = [
    'Project machine name [%default_machine_name%]:' => 'example',
    'Description:' => 'Example description.',
    'Type [drupal-module]:' => 'drupal-module',
    'Is this project hosted on drupal.org? [No]:' => 'Yes',
  ];

  protected array $fixtures = [
    'composer.json' => '/_composer.json',
  ];

}

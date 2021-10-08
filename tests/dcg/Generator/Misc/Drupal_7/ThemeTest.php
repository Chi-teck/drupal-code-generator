<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Misc\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:d7:theme command.
 */
final class ThemeTest extends BaseGeneratorTest {

  protected string $class = 'Misc\Drupal_7\Theme';

  protected array $interaction = [
    'Theme name [%default_name%]:' => 'Example',
    'Theme machine name [example]:' => 'example',
    'Theme description [A simple Drupal 7 theme.]:' => 'A theme for test.',
    'Base theme:' => 'garland',
  ];

  protected array $fixtures = [
    'example/images' => [],
    'example/templates' => [],
    'example/example.info' => '/_theme/example.info',
    'example/template.php' => '/_theme/template.php',
    'example/css/example.css' => '/_theme/css/example.css',
    'example/js/example.js' => '/_theme/js/example.js',
  ];

}

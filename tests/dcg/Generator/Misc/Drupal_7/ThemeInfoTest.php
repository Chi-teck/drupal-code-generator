<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Misc\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:d7:theme-info-file command.
 */
final class ThemeInfoTest extends BaseGeneratorTest {

  protected $class = 'Misc\Drupal_7\ThemeInfo';

  protected $interaction = [
    'Theme name [%default_name%]:' => 'Bar',
    'Theme machine name [bar]:' => 'bar',
    'Theme description [A simple Drupal 7 theme.]:' => 'Theme description',
    'Base theme:' => 'omega',
  ];

  protected $fixtures = [
    'bar.info' => '/_theme.info',
  ];

}

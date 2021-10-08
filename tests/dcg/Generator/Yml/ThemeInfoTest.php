<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Yml;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for yml:theme-info command.
 */
final class ThemeInfoTest extends BaseGeneratorTest {

  protected $class = 'Yml\ThemeInfo';

  protected $interaction = [
    'Theme name [%default_name%]:' => 'Example',
    'Theme machine name [example]:' => 'example',
    'Base theme [classy]:' => 'garland',
    'Description [A flexible theme with a responsive, mobile-first layout.]:' => 'Example description.',
    'Package [Custom]:' => 'Custom',
  ];

  protected $fixtures = [
    'example.info.yml' => '/_theme_info.yml',
  ];

}

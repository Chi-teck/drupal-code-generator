<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Misc\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:d7:template.php command.
 */
final class TemplatePhpTest extends BaseGeneratorTest {

  protected string $class = 'Misc\Drupal_7\TemplatePhp';

  protected array $interaction = [
    'Theme name [%default_name%]:' => 'Example',
    'Theme machine name [example]:' => 'example',
  ];

  protected array $fixtures = [
    'template.php' => '/_template.php',
  ];

}

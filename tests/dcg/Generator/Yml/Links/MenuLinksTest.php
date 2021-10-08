<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Yml\Links;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for yml:menu:links command.
 */
class MenuLinksTest extends BaseGeneratorTest {

  protected $class = 'Yml\Links\Menu';

  protected $interaction = [
    'Module machine name [%default_machine_name%]:' => 'example',
  ];

  protected $fixtures = [
    'example.links.menu.yml' => '/_links.menu.yml',
  ];

}

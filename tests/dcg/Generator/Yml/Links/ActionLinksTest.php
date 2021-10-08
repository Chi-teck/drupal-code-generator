<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Yml\Links;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for yml:links:action command.
 */
class ActionLinksTest extends BaseGeneratorTest {

  protected $class = 'Yml\Links\Action';

  protected $interaction = [
    'Module machine name [%default_machine_name%]:' => 'example',
  ];

  protected $fixtures = [
    'example.links.action.yml' => '/_links.action.yml',
  ];

}

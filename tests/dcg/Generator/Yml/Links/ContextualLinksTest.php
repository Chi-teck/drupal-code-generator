<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Yml\Links;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for yml:links:contextual command.
 */
class ContextualLinksTest extends BaseGeneratorTest {

  protected $class = 'Yml\Links\Contextual';

  protected $interaction = [
    'Module machine name [%default_machine_name%]:' => 'example',
  ];

  protected $fixtures = [
    'example.links.contextual.yml' => '/_links.contextual.yml',
  ];

}

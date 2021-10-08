<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Yml\Links;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for yml:links:contextual command.
 */
class ContextualLinksTest extends BaseGeneratorTest {

  protected string $class = 'Yml\Links\Contextual';

  protected array $interaction = [
    'Module machine name [%default_machine_name%]:' => 'example',
  ];

  protected array $fixtures = [
    'example.links.contextual.yml' => '/_links.contextual.yml',
  ];

}

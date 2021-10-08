<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Yml;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for yml:routing command.
 */
final class RoutingTest extends BaseGeneratorTest {

  protected string $class = 'Yml\Routing';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
  ];

  protected array $fixtures = [
    'example.routing.yml' => '/_routing.yml',
  ];

}

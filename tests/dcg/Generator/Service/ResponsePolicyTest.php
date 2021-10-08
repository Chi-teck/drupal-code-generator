<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:response-policy command.
 */
final class ResponsePolicyTest extends BaseGeneratorTest {

  protected string $class = 'Service\ResponsePolicy';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [Example]:' => 'Example',
  ];

  protected array $fixtures = [
    'foo.services.yml' => '/_response_policy.services.yml',
    'src/PageCache/Example.php' => '/_response_policy.php',
  ];

}

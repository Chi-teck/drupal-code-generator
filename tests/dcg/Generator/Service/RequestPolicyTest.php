<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:request-policy command.
 */
final class RequestPolicyTest extends BaseGeneratorTest {

  protected string $class = 'Service\RequestPolicy';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [Example]:' => 'Example',
  ];

  protected array $fixtures = [
    'foo.services.yml' => '/_request_policy.services.yml',
    'src/PageCache/Example.php' => '/_request_policy.php',
  ];

}

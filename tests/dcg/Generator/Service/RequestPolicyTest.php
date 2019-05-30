<?php

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:request-policy command.
 */
class RequestPolicyTest extends BaseGeneratorTest {

  protected $class = 'Service\RequestPolicy';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [Example]:' => 'Example',
  ];

  protected $fixtures = [
    'foo.services.yml' => '/_request_policy.services.yml',
    'src/PageCache/Example.php' => '/_request_policy.php',
  ];

}

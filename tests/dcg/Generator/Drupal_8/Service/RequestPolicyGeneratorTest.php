<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for d8:service:request-policy command.
 */
class RequestPolicyGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Drupal_8\Service\RequestPolicy';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [Example]:' => 'Example',
  ];

  protected $fixtures = [
    'foo.services.yml' => __DIR__ . '/_request_policy.services.yml',
    'src/PageCache/Example.php' => __DIR__ . '/_request_policy.php',
  ];

}

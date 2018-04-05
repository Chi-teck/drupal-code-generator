<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Service;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:service:response-policy command.
 */
class ResponsePolicyTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Service\ResponsePolicy';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [Example]:' => 'Example',
  ];

  protected $fixtures = [
    'foo.services.yml' => __DIR__ . '/_response_policy.services.yml',
    'src/PageCache/Example.php' => __DIR__ . '/_response_policy.php',
  ];

}

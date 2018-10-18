<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Service;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:service:cache-context command with calculated option 'On'.
 */
class CacheContextCalculatedTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Service\CacheContext';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Bar',
    'Module machine name [bar]:' => 'bar',
    'Context ID [example]:' => 'example',
    'Class [ExampleCacheContext]:' => 'ExampleCacheContext',
    "Base class:\n  [0] -\n  [1] RequestStackCacheContextBase\n  [2] UserCacheContextBase\n ➤➤➤ " => 1,
    'Make the context calculated? [No]:' => 'Yes',
  ];

  protected $fixtures = [
    'bar.services.yml' => __DIR__ . '/_cache_context_calculated.services.yml',
    'src/Cache/Context/ExampleCacheContext.php' => __DIR__ . '/_cache_context_calculated.php',
  ];

  /**
   * {@inheritdoc}
   */
  protected function processExpectedDisplay($display) {
    return str_replace(" ➤➤➤ \n ➤ ", '  ➤➤➤ ', $display);
  }

}

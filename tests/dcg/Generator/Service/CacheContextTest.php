<?php

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:cache-context command.
 */
class CacheContextTest extends BaseGeneratorTest {

  protected $class = 'Service\CacheContext';

  /**
   * Test callback.
   */
  public function testCalculatedNo() {
    parent::doTest(self::getInteraction('no'), self::getFixtures('no'));
  }

  /**
   * Test callback.
   */
  public function testCalculatedYes() {
    parent::doTest(self::getInteraction('yes'), self::getFixtures('yes'));
  }

  /**
   * Returns test fixtures.
   */
  protected static function getFixtures($calculated) {
    $dir = __DIR__ . '/_cache_context_calculated_' . $calculated;
    return [
      'foo.services.yml' => $dir . '/_cache_context.services.yml',
      'src/Cache/Context/ExampleCacheContext.php' => $dir . '/_cache_context.php',
    ];
  }

  /**
   * Returns command interaction.
   */
  protected static function getInteraction($calculated) {
    return [
      'Module name [%default_name%]:' => 'Foo',
      'Module machine name [foo]:' => 'foo',
      'Context ID [example]:' => 'example',
      'Class [ExampleCacheContext]:' => 'ExampleCacheContext',
      "Base class:\n  [0] -\n  [1] RequestStackCacheContextBase\n  [2] UserCacheContextBase" => 1,
      'Make the context calculated? [No]:' => $calculated,
    ];
  }

}

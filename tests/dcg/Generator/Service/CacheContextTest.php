<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:cache-context command.
 */
final class CacheContextTest extends BaseGeneratorTest {

  protected $class = 'Service\CacheContext';

  /**
   * Test callback.
   */
  public function testCalculatedNo(): void {
    parent::doTest(self::getInteraction('no'), self::getFixtures('no'));
  }

  /**
   * Test callback.
   */
  public function testCalculatedYes(): void {
    parent::doTest(self::getInteraction('yes'), self::getFixtures('yes'));
  }

  /**
   * Returns test fixtures.
   */
  private static function getFixtures(string $calculated): array {
    $dir = '/_cache_context_calculated_' . $calculated;
    return [
      'foo.services.yml' => $dir . '/_cache_context.services.yml',
      'src/Cache/Context/ExampleCacheContext.php' => $dir . '/_cache_context.php',
    ];
  }

  /**
   * Returns command interaction.
   */
  private static function getInteraction(string $calculated): array {
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

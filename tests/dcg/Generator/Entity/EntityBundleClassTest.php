<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Entity;

use DrupalCodeGenerator\Command\Entity\EntityBundleClass;
use DrupalCodeGenerator\Test\GeneratorTest;

/**
 * Test for entity:bundle-class command.
 *
 * @todo Create a full test with Drupal context.
 */
final class EntityBundleClassTest extends GeneratorTest {

  protected string $fixtureDir = __DIR__;

  /**
   * Test callback.
   */
  public function testWithEmptyDrupalContext(): void {
    $this->execute(new EntityBundleClass(), []);

    self::assertStringContainsString('This command requires a fully bootstrapped Drupal instance.', $this->display);
  }

}

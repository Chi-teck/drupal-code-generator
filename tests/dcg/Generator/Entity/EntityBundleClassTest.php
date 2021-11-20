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

    $expected_display = <<< 'TXT'

     Welcome to entity-bundle-class generator!
    –––––––––––––––––––––––––––––––––––––––––––

     [ERROR] This command requires a fully bootstrapped Drupal instance.                                                    


    TXT;

    $this->assertDisplay($expected_display);

  }

}

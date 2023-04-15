<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional;

use Drupal\Core\DependencyInjection\ClassResolver;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorFactory;
use DrupalCodeGenerator\Test\Functional\FunctionalTestBase;

/**
 * Test for GeneratorsDiscovery.
 *
 * @todo Test required API version and fatal errors.
 */
final class GeneratorFactoryTest extends FunctionalTestBase {

  private const TOTAL_GENERATORS = 2;

  /**
   * Test callback.
   */
  public function testGetGenerators(): void {
    $this->markTestSkipped('@todo Enable it once we update all generators to use BaseGenerator class.');
    $class_resolver = new ClassResolver();
    $class_resolver->setContainer($this->application->getContainer());
    $factory = new GeneratorFactory($class_resolver);

    $generators = $factory->getGenerators();
    foreach ($generators as $generator) {
      self::assertInstanceOf(BaseGenerator::class, $generator);
    }
    self::assertCount(self::TOTAL_GENERATORS, $generators);
  }

}

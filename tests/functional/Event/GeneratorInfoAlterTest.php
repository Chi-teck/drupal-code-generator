<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Event;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Event\GeneratorInfo;
use DrupalCodeGenerator\Event\GeneratorInfoAlter;
use DrupalCodeGenerator\Test\Functional\FunctionalTestBase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Test GeneratorInfoAlter event.
 */
final class GeneratorInfoAlterTest extends FunctionalTestBase {

  /**
   * Test callback.
   */
  public function testGeneratorInfoAlter(): void {
    $container = self::bootstrap();
    $dispatcher = $container->get('event_dispatcher');

    $info_listener = static function (GeneratorInfo $generator_info): void {
      $generator_info->addGenerators(
        self::createTestGenerator('test-1'),
        self::createTestGenerator('test-2'),
        self::createTestGenerator('test-3'),
      );
    };
    $dispatcher->addListener(GeneratorInfo::class, $info_listener);

    $info_alter_listener = static function (GeneratorInfoAlter $generator_info): void {
      unset($generator_info->generators['test-2']);
      $generator_info->generators['test-3']
        ->setName('test-3-altered');
    };
    $dispatcher->addListener(GeneratorInfoAlter::class, $info_alter_listener);

    $application = self::createApplication($container);

    self::assertTrue($application->has('test-1'));
    self::assertFalse($application->has('test-2'));
    self::assertFalse($application->has('test-3'));
    self::assertTrue($application->has('test-3-altered'));

    $application->run(new StringInput('test-3 --help'), new BufferedOutput());
  }

  /**
   * Creates a generator for testing.
   */
  private static function createTestGenerator(string $name): BaseGenerator {
    return new class($name) extends BaseGenerator {

      public function __construct(
        private readonly string $generatorName,
      ) {
        parent::__construct();
      }

      protected function generate(array &$vars, AssetCollection $assets): void {
        // Intentionally empty.
      }

      protected function getGeneratorDefinition(): Generator {
        return new Generator($this->generatorName);
      }

    };
  }

}

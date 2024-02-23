<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Event;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Event\GeneratorInfo;
use DrupalCodeGenerator\Test\Functional\FunctionalTestBase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Test generator info event.
 */
final class GeneratorInfoTest extends FunctionalTestBase {

  /**
   * Test callback.
   */
  public function testGeneratorInfo(): void {

    $listener = static function (GeneratorInfo $generator_info): void {
      $generator_info->addGenerators(
        self::createTestGenerator('test-1'),
        self::createTestGenerator('test-2'),
        self::createTestGenerator('test-3'),
      );
    };

    $container = self::bootstrap();
    $container
      ->get('event_dispatcher')
      ->addListener(GeneratorInfo::class, $listener);

    $application = self::createApplication($container);

    self::assertTrue($application->has('test-1'));
    self::assertTrue($application->has('test-2'));
    self::assertTrue($application->has('test-3'));

    $application->run(
      new StringInput('test-1'),
      $output = new BufferedOutput(),
    );

    $expected_output = <<< 'TXT'

     Welcome to test-1 generator!
    ––––––––––––––––––––––––––––––
    It works!

    TXT;
    self::assertSame($expected_output, $output->fetch());
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
        $this->io()->writeln('It works!');
      }

      protected function getGeneratorDefinition(): Generator {
        return new Generator($this->generatorName);
      }

    };
  }

}

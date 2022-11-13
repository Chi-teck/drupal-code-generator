<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Event;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Asset\Directory;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Event\AssetPostProcess;
use DrupalCodeGenerator\Event\AssetPreProcess;
use DrupalCodeGenerator\Test\Functional\FunctionalTestBase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Test process events.
 */
final class ProcessEventTest extends FunctionalTestBase {

  /**
   * Test callback.
   */
  public function testPreProcessEvent(): void {
    $application = self::createApplication();
    $application->add(self::createTestGenerator());

    $listener = static function (AssetPreProcess $event): void {
      $event->destination .= '/changed';
      /** @var \DrupalCodeGenerator\Asset\File $file */
      $file = $event->assets[0];
      $file->content($file->getContent() . \PHP_EOL . 'New content.');
      $event->assets[] = new File('new-file.txt');
      $event->assets[] = new Directory('extra/directory');
    };
    $application->getContainer()
      ->get('event_dispatcher')
      ->addListener(AssetPreProcess::class, $listener);

    $application->run(
      new StringInput('test -d ' . $this->directory),
      $output = new BufferedOutput(),
    );

    $expected_output = <<< 'TXT'
      Welcome to test generator!
      ––––––––––––––––––––––––––––

       The following directories and files have been created or updated:
      –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
       • extra/directory
       • example.txt
       • new-file.txt
      TXT;
    self::assertSame($expected_output, \trim($output->fetch()));

    self::assertDirectoryExists($this->directory . '/changed/extra/directory');
    self::assertSame(
      'Original content.' . \PHP_EOL . 'New content.',
      \file_get_contents($this->directory . '/changed/example.txt'),
    );
    self::assertFileExists($this->directory . '/changed/new-file.txt');
  }

  /**
   * Test callback.
   */
  public function testPostProcessEvent(): void {
    $application = self::createApplication();
    $application->add(self::createTestGenerator());

    $listener = function (AssetPostProcess $event): void {
      /** @var \DrupalCodeGenerator\Asset\File $file */
      $file = $event->assets[0];
      $path = $this->directory . '/' . $file->getPath();
      \file_put_contents($path, $file->getContent() . \PHP_EOL . 'New content.');
      $event->assets[] = new File('new-file.txt');
      $event->assets[] = new Directory('extra/directory');
    };
    $application->getContainer()
      ->get('event_dispatcher')
      ->addListener(AssetPostProcess::class, $listener);

    $application->run(
      new StringInput('test -d ' . $this->directory),
      $output = new BufferedOutput(),
    );

    $expected_output = <<< 'TXT'
      Welcome to test generator!
      ––––––––––––––––––––––––––––

       The following directories and files have been created or updated:
      –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
       • extra/directory
       • example.txt
       • new-file.txt
      TXT;
    self::assertSame($expected_output, \trim($output->fetch()));
    self::assertSame(
      'Original content.' . \PHP_EOL . 'New content.',
      \file_get_contents($this->directory . '/example.txt'),
    );
  }

  /**
   * Creates a generator for testing.
   */
  private static function createTestGenerator(): BaseGenerator {
    return new class() extends BaseGenerator {

      protected function generate(array &$vars, AssetCollection $assets): void {
        $assets->addFile('example.txt')->content('Original content.');
      }

      protected function getGeneratorDefinition(): Generator {
        return new Generator('test');
      }

    };
  }

}

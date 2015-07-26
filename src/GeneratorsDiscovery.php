<?php

namespace DrupalCodeGenerator;

use ReflectionClass;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @TODO: Create a test for this.
 */
class GeneratorsDiscovery {

  const COMMANDS_NAMESPACE = '\DrupalCodeGenerator\Commands\\';
  const COMMANDS_BASE_CLASS = '\DrupalCodeGenerator\Commands\BaseGenerator';

  protected $directories = [];

  /**
   * Constructs discovery object.
   */
  public function __construct(array $directories) {
    $this->directories = $directories;
  }

  /**
   * Finds and instantiates generator commands.
   *
   * @return \Symfony\Component\Console\Command\Command[] $commands
   */
  public function getGenerators() {
    $filesystem = new Filesystem();

    $commands = [];
    foreach ($this->directories as $directory) {
      $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS)
      );

      foreach ($iterator as $path => $file) {
        if ($file->getExtension() == 'php') {
          $relative_path = $filesystem->makePathRelative($path, $directory);
          $class = self::COMMANDS_NAMESPACE . str_replace('/', '\\', preg_replace('#.php/$#', '', $relative_path));
          $reflected_class = new ReflectionClass($class);

          if ($reflected_class->isAbstract() || !$reflected_class->isSubclassOf(self::COMMANDS_BASE_CLASS)) {
            continue;
          }

          $commands[] = new $class;
        }
      }

    }

    return $commands;
  }

}

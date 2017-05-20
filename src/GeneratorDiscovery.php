<?php

namespace DrupalCodeGenerator;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Discovery of generator commands.
 */
class GeneratorDiscovery {

  const COMMANDS_BASE_INTERFACE = '\DrupalCodeGenerator\Commands\GeneratorInterface';

  /**
   * Commands namespace.
   *
   * @var string
   */
  protected $namespace;

  /**
   * The file system utility.
   *
   * @var Filesystem
   */
  protected $filesystem;

  /**
   * Constructs discovery object.
   */
  public function __construct(Filesystem $filesystem, $namespace = '\DrupalCodeGenerator\Commands') {
    $this->filesystem = $filesystem;
    $this->namespace = $namespace;
  }

  /**
   * Finds and instantiates generator commands.
   *
   * @param array $command_directories
   *   Directories to look up for commands.
   *
   * @return \Symfony\Component\Console\Command\Command[]
   *   Array of generators.
   */
  public function getGenerators(array $command_directories) {
    $commands = [];
    foreach ($command_directories as $directory) {
      $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS)
      );

      foreach ($iterator as $path => $file) {
        if ($file->getExtension() == 'php') {
          $relative_path = $this->filesystem->makePathRelative($path, $directory);
          $class = $this->namespace . '\\' . str_replace('/', '\\', preg_replace('#.php/$#', '', $relative_path));
          if (class_exists($class)) {
            $reflected_class = new ReflectionClass($class);
            if (!$reflected_class->isInterface() && !$reflected_class->isAbstract() && $reflected_class->implementsInterface(self::COMMANDS_BASE_INTERFACE)) {
              $commands[] = new $class();
            }
          }
        }
      }

    }

    return $commands;
  }

}

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

  const COMMAND_INTERFACE = '\DrupalCodeGenerator\Command\GeneratorInterface';

  /**
   * The file system utility.
   *
   * @var \Symfony\Component\Filesystem\Filesystem
   */
  protected $filesystem;

  /**
   * Constructs discovery object.
   *
   * @param \Symfony\Component\Filesystem\Filesystem $filesystem
   *   The file system utility.
   */
  public function __construct(Filesystem $filesystem) {
    $this->filesystem = $filesystem;
  }

  /**
   * Finds and instantiates generator commands.
   *
   * @param array $command_directories
   *   Directories to look up for commands.
   * @param string $namespace
   *   (Optional) The namespace to filter out commands.
   *
   * @return \Symfony\Component\Console\Command\Command[]
   *   Array of generators.
   */
  public function getGenerators(array $command_directories, $namespace = '\DrupalCodeGenerator\Command') {
    $commands = [];

    foreach ($command_directories as $directory) {
      $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS)
      );
      foreach ($iterator as $path => $file) {
        if ($file->getExtension() == 'php') {
          $relative_path = $this->filesystem->makePathRelative($path, $directory);
          $class = $namespace . '\\' . str_replace('/', '\\', preg_replace('#\.php/$#', '', $relative_path));
          if (class_exists($class)) {
            $reflected_class = new ReflectionClass($class);
            if (!$reflected_class->isInterface() && !$reflected_class->isAbstract() && $reflected_class->implementsInterface(self::COMMAND_INTERFACE)) {
              $commands[] = new $class();
            }
          }
        }
      }
    }

    return $commands;
  }

}

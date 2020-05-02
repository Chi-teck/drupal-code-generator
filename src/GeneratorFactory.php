<?php

namespace DrupalCodeGenerator;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Defines generator factory.
 */
final class GeneratorFactory {

  private const COMMAND_INTERFACE = '\DrupalCodeGenerator\Command\GeneratorInterface';

  /**
   * The file system utility.
   *
   * @var \Symfony\Component\Filesystem\Filesystem
   */
  private $filesystem;

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
   * @param string[] $directories
   *   Directories to look up for commands.
   * @param string $namespace
   *   (Optional) The namespace to filter out commands.
   *
   * @return \Symfony\Component\Console\Command\Command[]
   *   Array of generators.
   */
  public function getGenerators(array $directories, string $namespace = '\DrupalCodeGenerator\Command'): array {
    $commands = [];

    foreach ($directories as $directory) {
      $iterator = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS)
      );
      foreach ($iterator as $file) {
        if ($file->getExtension() == 'php') {
          $sub_path = $iterator->getInnerIterator()->getSubPath();
          $sub_namespace = $sub_path ? \str_replace(DIRECTORY_SEPARATOR, '\\', $sub_path) . '\\' : '';
          $class = $namespace . '\\' . $sub_namespace . $file->getBasename('.php');
          if (\class_exists($class)) {
            $reflected_class = new \ReflectionClass($class);
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

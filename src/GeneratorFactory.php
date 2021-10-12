<?php declare(strict_types=1);

namespace DrupalCodeGenerator;

use DrupalCodeGenerator\ClassResolver\ClassResolverInterface;

/**
 * Defines generator factory.
 */
final class GeneratorFactory {

  private const COMMAND_INTERFACE = '\DrupalCodeGenerator\Command\GeneratorInterface';

  private ClassResolverInterface $classResolver;

  /**
   * The object constructor.
   */
  public function __construct(ClassResolverInterface $class_resolver) {
    $this->classResolver = $class_resolver;
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
        new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS),
      );
      foreach ($iterator as $file) {
        if ($file->getExtension() == 'php') {
          $sub_path = $iterator->getInnerIterator()->getSubPath();
          $sub_namespace = $sub_path ? \str_replace(\DIRECTORY_SEPARATOR, '\\', $sub_path) . '\\' : '';
          $class = $namespace . '\\' . $sub_namespace . $file->getBasename('.php');
          if (\class_exists($class)) {
            $reflected_class = new \ReflectionClass($class);
            if (!$reflected_class->isInterface() && !$reflected_class->isAbstract() && $reflected_class->implementsInterface(self::COMMAND_INTERFACE)) {
              $commands[] = $this->classResolver->getInstance($class);
            }
          }
        }
      }
    }

    return $commands;
  }

}

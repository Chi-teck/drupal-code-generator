<?php

namespace DrupalCodeGenerator;

use DrupalCodeGenerator\Commands\GeneratorInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Dumper;
use Twig_Environment;

/**
 * Discovery of generator commands.
 */
class GeneratorDiscovery {

  const COMMANDS_NAMESPACE = '\DrupalCodeGenerator\Commands\\';
  const COMMANDS_BASE_INTERFACE = '\DrupalCodeGenerator\Commands\GeneratorInterface';

  /**
   * List of directories to look up.
   *
   * @var array
   */
  protected $directories = [];

  /**
   * The file system utility.
   *
   * @var Filesystem
   */
  protected $filesystem;

  /**
   * The twig environment.
   *
   * @var Twig_Environment
   */
  protected $twig;

  /**
   * The yaml dumper.
   *
   * @var Dumper
   */
  protected $yamlDumper;

  /**
   * Constructs discovery object.
   */
  public function __construct(array $directories, Filesystem $filesystem, Twig_Environment $twig, Dumper $yaml_dumper) {
    $this->directories = $directories;
    $this->filesystem = $filesystem;
    $this->twig = $twig;
    $this->yamlDumper = $yaml_dumper;
  }

  /**
   * Finds and instantiates generator commands.
   *
   * @return GeneratorInterface[]
   *   Array of generators.
   */
  public function getGenerators() {

    $commands = [];
    foreach ($this->directories as $directory) {
      $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS)
      );

      foreach ($iterator as $path => $file) {
        if ($file->getExtension() == 'php') {
          $relative_path = $this->filesystem->makePathRelative($path, $directory);
          $class = self::COMMANDS_NAMESPACE . str_replace('/', '\\', preg_replace('#.php/$#', '', $relative_path));
          $reflected_class = new ReflectionClass($class);

          if (!$reflected_class->isInterface() && !$reflected_class->isAbstract() && $reflected_class->implementsInterface(self::COMMANDS_BASE_INTERFACE)) {
            $commands[] = new $class($this->filesystem, $this->twig, $this->yamlDumper);
          }

        }
      }

    }

    return $commands;
  }

}

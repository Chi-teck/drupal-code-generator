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

  const COMMANDS_NAMESPACE = '\DrupalCodeGenerator\Commands\\';
  const COMMANDS_BASE_INTERFACE = '\DrupalCodeGenerator\Commands\GeneratorInterface';

  /**
   * Directories to look up for commands.
   *
   * @var array
   */
  protected $commandDirectories = [];

  /**
   * Directories to look up for templates.
   *
   * @var array
   */
  protected $twigDirectories = [];

  /**
   * The file system utility.
   *
   * @var Filesystem
   */
  protected $filesystem;

  /**
   * The twig environment.
   *
   * @var \Twig_Environment
   */
  protected $twig;

  /**
   * The yaml dumper.
   *
   * @var \Symfony\Component\Yaml\Dumper
   */
  protected $yamlDumper;

  /**
   * Constructs discovery object.
   */
  public function __construct(array $command_directories, array $twig_directories, Filesystem $filesystem) {
    $this->commandDirectories = $command_directories;
    $this->twigDirectories = $twig_directories;
    $this->filesystem = $filesystem;
  }

  /**
   * Finds and instantiates generator commands.
   *
   * @return \Symfony\Component\Console\Command\Command[]
   *   Array of generators.
   */
  public function getGenerators() {

    $commands = [];
    foreach ($this->commandDirectories as $directory) {
      $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS)
      );

      foreach ($iterator as $path => $file) {
        if ($file->getExtension() == 'php') {
          $relative_path = $this->filesystem->makePathRelative($path, $directory);
          $class = self::COMMANDS_NAMESPACE . str_replace('/', '\\', preg_replace('#.php/$#', '', $relative_path));
          $reflected_class = new ReflectionClass($class);

          if (!$reflected_class->isInterface() && !$reflected_class->isAbstract() && $reflected_class->implementsInterface(self::COMMANDS_BASE_INTERFACE)) {
            $commands[] = $class::create($this->twigDirectories);
          }

        }
      }

    }

    return $commands;
  }

}

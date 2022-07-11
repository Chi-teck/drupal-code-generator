<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Helper;

use Composer\InstalledVersions;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Exception\RuntimeException;
use DrupalCodeGenerator\InputOutput\IOAwareInterface;
use DrupalCodeGenerator\InputOutput\IOAwareTrait;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Cursor;
use Symfony\Component\Console\Helper\Helper;

/**
 * Rector processor.
 *
 * @todo Is it really needed?
 */
final class RectorProcessor extends Helper implements IOAwareInterface, LoggerAwareInterface {

  use IOAwareTrait;
  use LoggerAwareTrait;

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'rector_processor';
  }

  /**
   * Process dumped files using Rector library.
   */
  final public function process(AssetCollection $assets, string $destination): void {
    if (!InstalledVersions::isInstalled('rector/rector')) {
      $this->logger->debug('Rector is not installed.');
      return;
    }
    $rector_config = InstalledVersions::getRootPackage()['install_path'] . 'rector.php';
    if (!\file_exists($rector_config) || !\is_file($rector_config) || !\is_readable($rector_config)) {
      $this->logger->debug('Could not load rector config.');
      return;
    }

    $paths = [];
    $php_files = new \CallbackFilterIterator($assets->getFiles()->getIterator(), [self::class, 'isPhpFile']);
    foreach ($php_files as $file) {
      $paths[] = $destination . '/' . $file;
    }

    if (\count($paths) === 0) {
      $this->logger->debug('There are no PHP files to process by rector.');
      return;
    }

    $rector_path = InstalledVersions::getInstallPath('rector/rector');

    $command = $rector_path . '/bin/rector process --ansi --no-diffs --no-progress-bar ' . \implode(' ', $paths);
    $this->logger->debug('Executing `{command}`.', ['command' => $command]);

    $this->io()->getErrorStyle()->writeln(\PHP_EOL . ' <comment>Starting rector...</comment>');
    $output = NULL;
    $result = NULL;
    \exec($command, $output, $result);
    // Remove 'Starting rector...' message.
    (new Cursor($this->io()->getOutput()))
      ->moveUp()->clearLine()->moveUp()->clearLine();

    if ($result !== 0) {
      throw new RuntimeException('Rector processor failed.');
    }
    $this->io()->write(\implode(\PHP_EOL, $output));
  }

  /**
   * Checks if a given file is of PHP type.
   */
  private static function isPhpFile(File $file): bool {
    $extension = \pathinfo($file->getPath(), \PATHINFO_EXTENSION);
    return match($extension) {
      'php', 'module', 'theme', 'profile', 'inc' => TRUE,
      default => FALSE,
    };
  }

}

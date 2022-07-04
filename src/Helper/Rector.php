<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper;

use Composer\InstalledVersions;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Exception\RuntimeException;
use DrupalCodeGenerator\InputOutput\IOAwareInterface;
use DrupalCodeGenerator\InputOutput\IOAwareTrait;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Helper\Helper;

/**
 * Rector processor.
 */
final class Rector extends Helper implements IOAwareInterface, LoggerAwareInterface {

  use IOAwareTrait;
  use LoggerAwareTrait;

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'rector';
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

    $rector_path = InstalledVersions::getInstallPath('rector/rector');
    $paths = [];
    foreach ($assets->getPhpFiles() as $file) {
      $paths[] = $destination . '/' . $file;
    }
    $command = $rector_path . '/bin/rector process --ansi --no-diffs --no-progress-bar ' . \implode(' ', $paths);
    $this->logger->debug('Executing `{command}`.', ['command' => $command]);
    $output = NULL;
    $result = NULL;
    \exec($command, $output, $result);
    if ($result !== 0) {
      throw new RuntimeException('Rector processor failed.');
    }
    $this->io->write(\implode(\PHP_EOL, $output));
  }

}

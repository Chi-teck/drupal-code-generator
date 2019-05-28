<?php

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\Asset;
use DrupalCodeGenerator\IOAwareInterface;
use DrupalCodeGenerator\IOAwareTrait;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Asset dumper form generators.
 */
class Dumper extends Helper implements IOAwareInterface {

  use IOAwareTrait;

  /**
   * The file system utility.
   *
   * @var \Symfony\Component\Filesystem\Filesystem
   */
  public $filesystem;

  /**
   * Replace flag.
   *
   * A flag indicating whether or not the files can be replaced. If not set the
   * user will be prompted to confirm replacing of each existing file.
   *
   * @var bool|null
   */
  protected $replace;

  /**
   * Constructs a generator command.
   *
   * @param \Symfony\Component\Filesystem\Filesystem $filesystem
   *   The file system utility.
   * @param bool|null $replace
   *   (optional) Indicates weather or not existing files can be replaced.
   */
  public function __construct(Filesystem $filesystem, ?bool $replace = NULL) {
    $this->filesystem = $filesystem;
    $this->replace = $replace;
  }

  /**
   * {@inheritdoc}
   */
  public function getName() :string {
    return 'dumper';
  }

  /**
   * Dumps the generated code to file system.
   *
   * @param \DrupalCodeGenerator\Asset[] $assets
   *   Assets to be dumped.
   * @param string $directory
   *   The destination directory.
   * @param bool $dry_run
   *   Do not dump the files.
   *
   * @return \DrupalCodeGenerator\Asset[]
   *   A list of created or updated assets.
   */
  public function dump(array $assets, string $directory, bool $dry_run = FALSE) :array {

    $dumped_assets = [];

    foreach ($assets as $asset) {

      $file_path = $directory . '/' . $asset->getPath();
      $content = $asset->getContent();

      if ($this->filesystem->exists($file_path)) {
        // Recreating directories makes no sense.
        if ($asset->isDirectory()) {
          continue;
        }

        // Apply the action.
        $action = $asset->getAction();
        if ($action == Asset::PRESERVE) {
          continue;
        }
        if ($action == Asset::REPLACE && !$dry_run && !$this->confirmReplace($file_path)) {
          continue;
        }
        $existing_content = file_get_contents($file_path);
        if ($action == Asset::APPEND) {
          if ($asset->getHeaderSize() > 0) {
            $content = Utils::removeHeader($content, $asset->getHeaderSize());
          }
          $content = $existing_content . "\n" . $content;
        }
        elseif (is_callable($action)) {
          $content = $action($existing_content, $content);
        }

      }

      // Nothing to dump.
      if ($content === NULL && !$asset->isDirectory()) {
        continue;
      }

      // Print data to output stream.
      if ($dry_run) {
        $title = $file_path;
        if ($asset->isDirectory()) {
          $title .= ' (empty directory)';
        }
        $this->io->title($title);

        if ($content !== NULL) {
          $this->io->writeln($content);
        }

        continue;
      }
      // Save data to file system.
      else {
        // Default mode of all parent directories is 0777. It can be modified by
        // changing umask.
        $mode = $asset->getMode();

        if ($asset->isDirectory()) {
          $this->filesystem->mkdir([$file_path], $mode);
        }
        else {
          $this->filesystem->dumpFile($file_path, $content);
          $this->filesystem->chmod($file_path, $mode);
        }

        $dumped_assets[] = $asset;
      }

    }

    return $dumped_assets;
  }

  /**
   * Confirms file replace.
   */
  protected function confirmReplace(string $file_path) :bool {
    if ($this->replace === NULL) {
      return $this->io->confirm("The file <comment>$file_path</comment> already exists. Would you like to replace it?");
    }
    return $this->replace;
  }

}

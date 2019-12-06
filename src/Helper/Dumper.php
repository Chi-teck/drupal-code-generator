<?php

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\IOAwareInterface;
use DrupalCodeGenerator\IOAwareTrait;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use function file_get_contents;
use function is_callable;

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
  public function getName(): string {
    return 'dumper';
  }

  /**
   * Dumps the generated code to file system.
   *
   * @param \DrupalCodeGenerator\Asset\AssetCollection $assets
   *   Assets to be dumped.
   * @param string $directory
   *   The destination directory.
   * @param bool $dry_run
   *   Do not dump the files.
   *
   * @return \DrupalCodeGenerator\Asset\AssetCollection
   *   A list of created or updated assets.
   */
  public function dump(AssetCollection $assets, string $directory, bool $dry_run = FALSE): AssetCollection {

    $dumped_assets = new AssetCollection();

    // -- Directories.
    /** @var \DrupalCodeGenerator\Asset\Directory $asset */
    foreach ($assets->getDirectories() as $asset) {

      $file_path = $directory . '/' . $asset->getPath();

      // Recreating directories makes no sense.
      if (!$this->filesystem->exists($file_path)) {
        if ($dry_run) {
          $this->io->title($file_path . ' (empty directory)');
        }
        else {
          $this->filesystem->mkdir($file_path, $asset->getMode());
          $dumped_assets[] = $asset;
        }
      }

    }

    // -- Files.
    /** @var \DrupalCodeGenerator\Asset\File $asset */
    foreach ($assets->getFiles() as $asset) {

      $file_path = $directory . '/' . $asset->getPath();
      $content = $asset->getContent();

      if ($this->filesystem->exists($file_path)) {

        // Apply the action.
        $action = $asset->getAction();
        $existing_content = file_get_contents($file_path);
        if (is_callable($action)) {
          $content = $action($existing_content, $content);
        }
        else {
          if ($action == File::ACTION_SKIP) {
            continue;
          }
          elseif ($action == File::ACTION_REPLACE && !$dry_run && !$this->confirmReplace($file_path)) {
            continue;
          }
          elseif ($action == File::ACTION_APPEND) {
            $content = static::appendContent($existing_content, $content, $asset->getHeaderSize());
          }
        }

      }

      // Nothing to dump.
      if ($content === NULL) {
        continue;
      }

      if ($dry_run) {
        $this->io->title($file_path);
        if ($content !== NULL) {
          $this->io->writeln($content, OutputInterface::OUTPUT_RAW);
        }
      }
      else {
        $this->filesystem->dumpFile($file_path, $content);
        $this->filesystem->chmod($file_path, $asset->getMode());
        $dumped_assets[] = $asset;
      }

    }

    return $dumped_assets;
  }

  /**
   * Confirms file replace.
   */
  protected function confirmReplace(string $file_path): bool {
    if ($this->replace === NULL) {
      return $this->io->confirm("The file <comment>$file_path</comment> already exists. Would you like to replace it?");
    }
    return $this->replace;
  }

  /**
   * Appends generated content to the end of existing one.
   */
  protected static function appendContent(string $existing_content, ?string $new_content, int $header_size): string {
    if ($new_content === NULL) {
      return $existing_content;
    }
    if ($header_size > 0) {
      $new_content = implode("\n", array_slice(explode("\n", $new_content), $header_size));
    }
    return $existing_content . "\n" . $new_content;
  }

}

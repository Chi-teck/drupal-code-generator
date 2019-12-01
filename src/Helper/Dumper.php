<?php

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\Asset;
use DrupalCodeGenerator\IOAwareInterface;
use DrupalCodeGenerator\IOAwareTrait;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Output\OutputInterface;
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
  public function getName(): string {
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
  public function dump(array $assets, string $directory, bool $dry_run = FALSE): array {

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
        $existing_content = file_get_contents($file_path);
        if (is_callable($action)) {
          $content = $action($existing_content, $content);
        }
        else {
          if ($action == Asset::ACTION_SKIP) {
            continue;
          }
          elseif ($action == Asset::ACTION_REPLACE && !$dry_run && !$this->confirmReplace($file_path)) {
            continue;
          }
          elseif ($action == Asset::ACTION_APPEND) {
            $content = static::appendContent($existing_content, $content, $asset->getHeaderSize());
          }
        }

      }

      // Nothing to dump.
      if ($asset->isFile() && $content === NULL) {
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
          $this->io->writeln($content, OutputInterface::OUTPUT_RAW);
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

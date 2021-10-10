<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Symlink;
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
   */
  public Filesystem $filesystem;

  /**
   * Constructs a generator command.
   */
  public function __construct(Filesystem $filesystem) {
    $this->filesystem = $filesystem;
  }

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'dumper';
  }

  /**
   * Dumps the generated code to file system.
   */
  public function dump(AssetCollection $assets, string $destination, DumperOptions $options): AssetCollection {

    $dumped_assets = new AssetCollection();

    // -- Directories.
    /** @var \DrupalCodeGenerator\Asset\Directory $asset */
    foreach ($assets->getDirectories() as $directory) {

      $directory_path = $destination . '/' . $directory->getPath();

      // Recreating directories makes no sense.
      if (!$this->filesystem->exists($directory_path)) {
        if ($options->dryRun) {
          $this->io->title(($options->fullPath ? $directory_path : $directory->getPath()) . ' (empty directory)');
        }
        else {
          $this->filesystem->mkdir($directory_path, $directory->getMode());
          $dumped_assets[] = $directory;
        }
      }

    }

    // -- Files.
    /** @var \DrupalCodeGenerator\Asset\File $asset */
    foreach ($assets->getFiles() as $file) {

      $file_path = $destination . '/' . $file->getPath();
      $content = $file->getContent();

      if ($this->filesystem->exists($file_path)) {
        // Resolve $file.
        if ($resolver = $file->getResolver()) {
          $existing_content = \file_get_contents($file_path);
          $content = $resolver($existing_content, $content);
        }
        else {
          switch ($file->getAction()) {
            case File::ACTION_SKIP:
              continue 2;

            case File::ACTION_REPLACE:
              if (!$options->dryRun && !$this->confirmReplace($file_path, $options->replace)) {
                continue 2;
              }
              break;

            case File::ACTION_PREPEND:
              $existing_content = \file_get_contents($file_path);
              $content = static::prependContent($existing_content, $content);
              break;

            case File::ACTION_APPEND:
              $existing_content = \file_get_contents($file_path);
              $content = static::appendContent($existing_content, $content, $file->getHeaderSize());
              break;
          }
        }

      }

      // Nothing to dump.
      if ($content === NULL) {
        continue;
      }

      if ($options->dryRun) {
        $this->io->title($options->fullPath ? $file_path : $file->getPath());
        $this->io->writeln($content, OutputInterface::OUTPUT_RAW);
      }
      else {
        $this->filesystem->dumpFile($file_path, $content);
        $this->filesystem->chmod($file_path, $file->getMode());
        $dumped_assets[] = $file;
      }

    }

    // -- Symlinks.
    /** @var \DrupalCodeGenerator\Asset\Symlink $asset */
    foreach ($assets->getSymlinks() as $symlink) {

      $link_path = $destination . '/' . $symlink->getPath();

      if ($file_exists = $this->filesystem->exists($link_path)) {
        switch ($symlink->getAction()) {
          case Symlink::ACTION_SKIP:
            continue 2;

          case Symlink::ACTION_REPLACE:
            if (!$options->dryRun && !$this->confirmReplace($link_path, $options->replace)) {
              continue 2;
            }
            break;
        }
      }

      $target = $symlink->getTarget();

      if ($options->dryRun) {
        $this->io->title($options->fullPath ? $link_path : $symlink->getPath());
        $this->io->writeln('Symlink to ' . $target, OutputInterface::OUTPUT_RAW);
      }
      else {
        if ($file_exists) {
          $this->filesystem->remove($link_path);
        }
        if (!@\symlink($target, $link_path)) {
          throw new \RuntimeException('Could not create a symlink to ' . $target);
        }
        $this->filesystem->chmod($link_path, $symlink->getMode());
        $dumped_assets[] = $symlink;
      }

    }

    return $dumped_assets;
  }

  /**
   * Confirms file replace.
   */
  protected function confirmReplace(string $file_path, ?bool $replace): bool {
    if ($replace === NULL) {
      return $this->io->confirm("The file <comment>$file_path</comment> already exists. Would you like to replace it?");
    }
    return $replace;
  }

  /**
   * Prepends generated content to the existing one.
   */
  protected static function prependContent(string $existing_content, ?string $new_content): string {
    if ($new_content === NULL) {
      return $existing_content;
    }
    return $new_content . "\n" . $existing_content;
  }

  /**
   * Appends generated content to the end of existing one.
   */
  protected static function appendContent(string $existing_content, ?string $new_content, int $header_size): string {
    if ($new_content === NULL) {
      return $existing_content;
    }
    if ($header_size > 0) {
      $new_content = \implode("\n", \array_slice(\explode("\n", $new_content), $header_size));
    }
    return $existing_content . "\n" . $new_content;
  }

}

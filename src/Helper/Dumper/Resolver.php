<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Dumper;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\Directory;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Symlink;
use DrupalCodeGenerator\Helper\DumperOptions;
use DrupalCodeGenerator\Style\GeneratorStyleInterface;

final class Resolver {

  public function __construct(
    private DumperOptions $options,
    private GeneratorStyleInterface $io,
  ) {}

  public function __invoke(Asset $asset, string $path): ?Asset {
    return match (TRUE) {
      // Recreating directories makes no sense.
      $asset instanceof Directory => NULL,
      $asset instanceof File => $this->resolveFile($asset, $path),
      $asset instanceof Symlink => $this->resolveSymlink($asset, $path),
    };
  }

  private function resolveFile(File $file, string $path): ?File {
    $content = match ($file->getAction()) {
      File::ACTION_SKIP => NULL,
      File::ACTION_REPLACE => !$this->options->dryRun && !$this->confirmReplace($path) ? NULL : $file->getContent(),
      File::ACTION_PREPEND => self::prependContent($file, \file_get_contents($path)),
      File::ACTION_APPEND => self::appendContent($file, \file_get_contents($path)),
      default => throw new \LogicException('Unsupported file action'),
    };
    if ($content === NULL) {
      return NULL;
    }
    $resolved_file = clone $file;
    $resolved_file->content($content);
    return $resolved_file;
  }

  private function resolveSymlink(Symlink $symlink, string $path): ?Symlink {
    return match ($symlink->getAction()) {
      Symlink::ACTION_SKIP => NULL,
      Symlink::ACTION_REPLACE => !$this->options->dryRun && !$this->confirmReplace($path) ? NULL : clone $symlink,
    };
  }

  /**
   * Confirms file replace.
   */
  private function confirmReplace(string $path): bool {
    return $this->options->replace ??
      $this->io->confirm("The file <comment>$path</comment> already exists. Would you like to replace it?");
  }

  /**
   * Prepends generated content to the existing one.
   */
  private static function prependContent(File $file, string $existing_content): string {
    $new_content = $file->getContent();
    if ($new_content === NULL) {
      return $existing_content;
    }
    return $new_content . "\n" . $existing_content;
  }

  /**
   * Appends generated content to the end of existing one.
   */
  private static function appendContent(File $file, string $existing_content): string {
    $new_content = $file->getContent();
    if ($new_content === NULL) {
      return $existing_content;
    }
    $header_size = $file->getHeaderSize();
    if ($header_size > 0) {
      $new_content = \implode("\n", \array_slice(\explode("\n", $new_content), $header_size));
    }
    return $existing_content . "\n" . $new_content;
  }

}

<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset\Resolver;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Helper\DumperOptions;
use DrupalCodeGenerator\Style\GeneratorStyleInterface;

final class FileResolver implements ResolverInterface {

  public function __construct(
    private DumperOptions $options,
    private GeneratorStyleInterface $io,
  ) {}

  public function resolve(Asset $asset, string $path): File {
    if (!$asset instanceof File) {
      throw new \InvalidArgumentException('Wrong asset type.');
    }
    $resolved_file = clone $asset;
    return match (TRUE) {
      $asset->shouldPreserve() => $resolved_file,
      $asset->shouldReplace() => $this->shouldReplace($path) ? $asset : $asset->skipIfExists(),
      $asset->shouldPrepend() => self::prependContent($asset, \file_get_contents($path)),
      $asset->shouldAppend() => self::appendContent($asset, \file_get_contents($path)),
    };
  }

  /**
   * Checks if the file can be replaced.
   */
  private function shouldReplace(string $path): bool {
    return $this->options->replace ?? ($this->options->dryRun || $this->confirmReplace($path));
  }

  /**
   * Confirms file replace.
   */
  private function confirmReplace(string $path): bool {
    return $this->io->confirm("The file <comment>$path</comment> already exists. Would you like to replace it?");
  }

  /**
   * Prepends generated content to the existing one.
   */
  private static function prependContent(File $file, string $existing_content): File {
    $new_content = $file->getContent();
    if ($new_content === NULL) {
      return $file;
    }
    $file->content($new_content . "\n" . $existing_content);
    return $file;
  }

  /**
   * Appends generated content to the end of existing one.
   */
  private static function appendContent(File $file, string $existing_content): File {
    $new_content = $file->getContent();
    if ($new_content === NULL) {
      return $file;
    }
    $header_size = $file->getHeaderSize();
    if ($header_size > 0) {
      $new_content = \implode("\n", \array_slice(\explode("\n", $new_content), $header_size));
    }
    $file->content($existing_content . "\n" . $new_content);
    return $file;
  }

}

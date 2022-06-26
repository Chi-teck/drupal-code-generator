<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Resolver;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\ResolverAction;
use DrupalCodeGenerator\Helper\DumperOptions;
use DrupalCodeGenerator\Style\GeneratorStyleInterface;

final class FileResolver implements ResolverInterface {

  public function __construct(
    private DumperOptions $options,
    private GeneratorStyleInterface $io,
  ) {}

  public function supports(Asset $asset): bool {
    return $asset instanceof File;
  }

  public function resolve(Asset $asset, string $path): ?Asset {
    /** @var \DrupalCodeGenerator\Asset\File $asset */
    $content = match ($asset->getResolverAction()) {
      ResolverAction::SKIP => NULL,
      ResolverAction::REPLACE => !$this->options->dryRun && !$this->confirmReplace($path) ? NULL : $asset->getContent(),
      ResolverAction::PREPEND => self::prependContent($asset, \file_get_contents($path)),
      ResolverAction::APPEND => self::appendContent($asset, \file_get_contents($path)),
    };
    if ($content === NULL) {
      return NULL;
    }
    $resolved_file = clone $asset;
    $resolved_file->content($content);
    return $resolved_file;
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

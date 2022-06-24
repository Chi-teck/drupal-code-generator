<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Dumper;

use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Helper\DumperOptions;
use DrupalCodeGenerator\Style\GeneratorStyleInterface;

final class FileResolver {

  public function __construct(
    private DumperOptions $options,
    private GeneratorStyleInterface $io,
  ) {}

  public function __invoke(File $file, string $file_path): File {
    $content = match ($file->getAction()) {
      File::ACTION_SKIP => NULL,
      File::ACTION_REPLACE => !$this->options->dryRun && !$this->confirmReplace($file_path) ? NULL : $file->getContent(),
      File::ACTION_PREPEND => self::prependContent(\file_get_contents($file_path), $file),
      File::ACTION_APPEND => self::appendContent(\file_get_contents($file_path), $file),
      default => throw new \LogicException('Unsupported file action'),
    };
    $resolved_file = clone $file;
    $resolved_file->content($content);
    return $resolved_file;
  }

  /**
   * Confirms file replace.
   */
  private function confirmReplace(string $file_path): bool {
    return $this->options->replace ??
      $this->io->confirm("The file <comment>$file_path</comment> already exists. Would you like to replace it?");
  }

  /**
   * Prepends generated content to the existing one.
   */
  protected static function prependContent(string $existing_content, File $file): string {
    $new_content = $file->getContent();
    if ($new_content === NULL) {
      return $existing_content;
    }
    return $new_content . "\n" . $existing_content;
  }

  /**
   * Appends generated content to the end of existing one.
   */
  protected static function appendContent(string $existing_content, File $file): string {
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

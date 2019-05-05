<?php

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\InputAwareInterface;
use DrupalCodeGenerator\InputAwareTrait;
use DrupalCodeGenerator\OutputAwareInterface;
use DrupalCodeGenerator\OutputAwareTrait;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Asset dumper form generators.
 */
class Dumper extends Helper implements InputAwareInterface, OutputAwareInterface {

  use InputAwareTrait;
  use OutputAwareTrait;

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
   *   The working directory.
   *
   * @return \DrupalCodeGenerator\Asset[]
   *   A list of created or updated assets.
   */
  public function dump(array $assets, string $directory) :array {

    $dumped_assets = [];

    /** @var \DrupalCodeGenerator\Helper\QuestionHelper $question_helper */
    $question_helper = $this->getHelperSet()->get('question');

    foreach ($assets as $asset) {

      $content = $asset->getContent();
      $file_path = $directory . '/' . $asset->getPath();

      if ($this->filesystem->exists($file_path)) {

        if ($asset->isDirectory()) {
          continue;
        }

        $action = $asset->getAction();
        if ($action == 'replace') {
          if ($this->replace === FALSE) {
            continue;
          }
          elseif ($this->replace === NULL) {
            $question_text = "The file <comment>$file_path</comment> already exists. Would you like to replace it?";
            $question = new ConfirmationQuestion($question_text);
            if (!$question_helper->ask($this->input, $this->output, $question)) {
              continue;
            }
          }
        }

        else {
          $original_content = file_get_contents($file_path);
          if ($action == 'append') {
            $header_size = $asset->getHeaderSize();
            // Do not remove header if original file is empty.
            if ($original_content && $header_size > 0) {
              $content = Utils::removeHeader($content, $header_size);
            }
            $content = $original_content . "\n" . $content;
          }
          elseif (is_callable($action)) {
            $content = $action($original_content, $content);
          }
          else {
            throw new \UnexpectedValueException("Unsupported action: $action.");
          }
        }

      }

      // Default mode of all parent directories is 0777. It can be modified by
      // changing umask.
      $mode = $asset->getMode();

      // Save data to file system.
      if ($asset->isDirectory()) {
        $this->filesystem->mkdir([$file_path], $mode);
      }
      else {
        $this->filesystem->dumpFile($file_path, $content);
        $this->filesystem->chmod($file_path, $mode);
      }

      $dumped_assets[] = $asset;
    }

    return $dumped_assets;
  }

}

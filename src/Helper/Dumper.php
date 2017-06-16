<?php

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Output dumper form generators.
 */
class Dumper extends Helper {

  /**
   * The file system utility.
   *
   * @var \Symfony\Component\Filesystem\Filesystem
   */
  public $filesystem;

  /**
   * Input instance.
   *
   * @var \Symfony\Component\Console\Input\InputInterface
   */
  protected $input;

  /**
   * Output instance.
   *
   * @var \Symfony\Component\Console\Output\OutputInterface
   */
  protected $output;

  /**
   * Replace flag.
   *
   * @var bool
   */
  protected $replace;

  /**
   * Constructs a generator command.
   *
   * @param \Symfony\Component\Filesystem\Filesystem $filesystem
   *   The file system utility.
   * @param bool $replace
   *   (optional) Indicates weather or not existing files can be replaced.
   */
  public function __construct(Filesystem $filesystem, $replace = NULL) {
    $this->filesystem = $filesystem;
    $this->replace = $replace;
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return 'dcg_dumper';
  }

  /**
   * Dumps the generated code to file system.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   Input instance.
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   Output instance.
   *
   * @return array
   *   List of created or updated files.
   */
  public function dump(InputInterface $input, OutputInterface $output) {
    $this->input = $input;
    $this->output = $output;
    $formatter_style = new OutputFormatterStyle('black', 'cyan', []);
    $this->output->getFormatter()->setStyle('title', $formatter_style);

    $interactive = $input->isInteractive();

    // NULL means we should ask user for confirmation.
    if ($this->replace !== NULL) {
      $input->setInteractive(FALSE);
    }

    /** @var \DrupalCodeGenerator\Command\GeneratorInterface $command */
    $command = $this->getHelperSet()->getCommand();

    $dumped_files = $this->doDump($command->getFiles(), $command->getDirectory());

    $input->setInteractive($interactive);
    return $dumped_files;
  }

  /**
   * Dumps files.
   *
   * @param array $files
   *   Files to dump.
   * @param string $directory
   *   Directory where to dump the files.
   *
   * @return array
   *   List of created or updated files.
   */
  protected function doDump(array $files, $directory) {
    $dumped_files = [];

    foreach ($files as $file_name => $file_info) {

      // Support short syntax `$this->files['File.php'] => 'Rendered content';`.
      $content = is_array($file_info) ? $file_info['content'] : $file_info;

      $is_directory = $content === NULL;

      $file_path = $directory . '/' . $file_name;
      if ($this->filesystem->exists($file_path) && !$is_directory) {
        $action = isset($file_info['action']) ? $file_info['action'] : 'replace';
        if ($action == 'replace') {
          $question_text = sprintf('<info>The file <comment>%s</comment> already exists. Would you like to replace it?</info> [<comment>Yes</comment>]: ', $file_path);
          if (!$this->confirm($question_text)) {
            continue;
          }
        }
        else {
          $original_content = file_get_contents($file_path);
          if ($action == 'append') {
            $header_size = isset($file_info['header_size']) ? $file_info['header_size'] : 0;
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
            throw new \LogicException("Unsupported action: $action.");
          }
        }
      }

      // Default mode for all parent directories is 0777. It can be modified by
      // changing umask.
      $mode = isset($file_info['mode']) ? $file_info['mode'] : ($is_directory ? 0755 : 0644);

      // Save data to file system.
      if ($is_directory) {
        $this->filesystem->mkdir([$file_path], $mode);
      }
      else {
        $this->filesystem->dumpFile($file_path, $content);
        $this->filesystem->chmod($file_path, $mode);
      }

      $dumped_files[] = $file_name;
    }

    return $dumped_files;
  }

  /**
   * Asks a user for confirmation.
   *
   * @param string $question_text
   *   The question to ask to the user.
   *
   * @return bool
   *   User confirmation.
   */
  protected function confirm($question_text) {
    // If the input is not interactive print the question with default answer.
    if ($this->replace !== NULL) {
      $this->output->writeln($question_text . ($this->replace ? 'Yes' : 'No'));
    }
    $question = new ConfirmationQuestion($question_text, $this->replace !== FALSE);
    /** @var \Symfony\Component\Console\Helper\QuestionHelper $question_helper */
    $question_helper = $this->getHelperSet()->get('question');
    return $question_helper->ask($this->input, $this->output, $question);
  }

}

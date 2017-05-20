<?php

namespace DrupalCodeGenerator\Helpers;

use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Dumper as YamlDumper;

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
   * The yaml dumper.
   *
   * @var \Symfony\Component\Yaml\Dumper
   */
  protected $yamlDumper;

  /**
   * The base directory.
   *
   * @var string
   */
  protected $baseDirectory;

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
   * Constructs a generator command.
   *
   * @param \Symfony\Component\Filesystem\Filesystem $filesystem
   *   The file system utility.
   * @param \Symfony\Component\Yaml\Dumper $yaml_dumper
   *   The yaml dumper.
   */
  public function __construct(Filesystem $filesystem, YamlDumper $yaml_dumper) {
    $this->filesystem = $filesystem;
    $this->yamlDumper = $yaml_dumper;
    $this->yamlDumper->setIndentation(2);
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return 'dumper';
  }

  /**
   * Dumps the generated code to file system.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   Input instance.
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   Output instance.
   * @param \Symfony\Component\Console\Command\Command $command
   *   The generator command.
   *
   * @return array
   *   List of created or updated files.
   */
  public function dump(InputInterface $input, OutputInterface $output, Command $command) {
    $this->input = $input;
    $this->output = $output;
    $formatter_style = new OutputFormatterStyle('black', 'cyan', []);
    $this->output->getFormatter()->setStyle('title', $formatter_style);

    /** @var \DrupalCodeGenerator\Commands\GeneratorInterface $command */
    $directory = $command->getDirectory($input);
    $extension_root = Utils::getExtensionRoot($directory);
    $this->baseDirectory = ($extension_root ?: $directory) . '/';

    $assets = $command->getAssets();

    return array_merge(
      $this->dumpFiles($assets['files']),
      $this->dumpHooks($assets['hooks']),
      $this->dumpServices($assets['services'], $extension_root)
    );
  }

  /**
   * Dumps files.
   *
   * @param array $files
   *   Files to dump.
   *
   * @return array
   *   List of created or updated files.
   */
  protected function dumpFiles(array $files) {
    $dumped_files = [];
    /** @var \Symfony\Component\Console\Helper\QuestionHelper $question_helper */
    $question_helper = $this->getHelperSet()->get('question');
    foreach ($files as $file_name => $content) {

      $file_path = $this->baseDirectory . $file_name;
      if ($this->filesystem->exists($file_path)) {
        $question = new ConfirmationQuestion(
          sprintf('<info>The file <comment>%s</comment> already exists. Would you like to override it?</info> [<comment>Yes</comment>]: ', $file_path),
          TRUE
        );
        if (!$question_helper->ask($this->input, $this->output, $question)) {
          continue;
        }
      }

      // NULL means it is a directory.
      if ($content === NULL) {
        $this->filesystem->mkdir([$file_path], 0775);
      }
      else {
        // Default mode for all parent directories is 0777. It can be
        // modified by the current umask, which you can change using umask().
        $this->filesystem->dumpFile($file_path, $content);
        $this->filesystem->chmod($file_path, 0644);
      }

      $dumped_files[] = $file_name;
    }

    return $dumped_files;
  }

  /**
   * Dumps hooks.
   *
   * @param array $hooks
   *   Hooks to dump.
   *
   * @return array
   *   List of created or updated files.
   */
  protected function dumpHooks(array $hooks) {
    $dumped_files = [];

    // Dump hooks.
    foreach ($hooks as $file_name => $file_hooks) {
      // TODO: Fix this.
      $file_hooks = isset($file_hooks[0]) ? $file_hooks : [$file_hooks];
      foreach ($file_hooks as $hook_info) {
        $file_path = $this->baseDirectory . $file_name;
        // If the file exists append hook code to it.
        if ($this->filesystem->exists($file_path)) {
          $original_content = file_get_contents($file_path);
          $content = $original_content . "\n" . $hook_info['code'];
        }
        // Otherwise create a new file with provided file doc comment.
        else {
          $content = $hook_info['file_doc'] . "\n" . $hook_info['code'];
        }
        $this->filesystem->dumpFile($file_path, $content);
        $this->filesystem->chmod($file_path, 0644);
        $dumped_files[] = $file_name;
      }
    }

    return $dumped_files;
  }

  /**
   * Dumps services.
   *
   * @param array $services
   *   Services to dump.
   * @param string $extension_root
   *   Extension root directory.
   *
   * @return array
   *   List of created or updated files.
   */
  protected function dumpServices(array $services, $extension_root) {

    $dumped_files = [];

    $inline = 3;

    // Dump services.
    if ($services && $extension_root) {
      $extension_name = basename($extension_root);
      $file = $extension_root . '/' . $extension_name . '.services.yml';

      if ($this->filesystem->exists($file)) {
        $action = 'update';
        $intend = 2;
      }
      else {
        $this->services = ['services' => $services];
        $action = 'create';
        $intend = 0;
        $inline++;
      }

      $question = new ConfirmationQuestion(
        sprintf(
          '<info>Would you like to %s <comment>%s.services.yml</comment> file?</info> [<comment>Yes</comment>]: ',
          $action,
          $extension_name
        ),
        TRUE
      );

      /** @var \Symfony\Component\Console\Helper\QuestionHelper $question_helper */
      $question_helper = $this->getHelperSet()->get('question');
      if ($question_helper->ask($this->input, $this->output, $question)) {
        $yaml = $this->yamlDumper->dump($services, $inline, $intend);
        file_put_contents($file, $yaml, FILE_APPEND);
        $dumped_files[] = $extension_name . '.services.yml';
      }
    }

    return $dumped_files;
  }

}

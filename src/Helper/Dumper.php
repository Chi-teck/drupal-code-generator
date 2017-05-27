<?php

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\Utils;
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
   * Override flag.
   *
   * @var bool
   */
  protected $override;

  /**
   * Constructs a generator command.
   *
   * @param \Symfony\Component\Filesystem\Filesystem $filesystem
   *   The file system utility.
   * @param \Symfony\Component\Yaml\Dumper $yaml_dumper
   *   The yaml dumper.
   * @param bool $override
   *   (optional) Indicates weather or not existing files can be overridden.
   */
  public function __construct(Filesystem $filesystem, YamlDumper $yaml_dumper, $override = NULL) {
    $this->filesystem = $filesystem;
    $this->yamlDumper = $yaml_dumper;
    $this->yamlDumper->setIndentation(2);
    $this->override = $override;
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
    if ($this->override !== NULL) {
      $input->setInteractive(FALSE);
    }

    /** @var \DrupalCodeGenerator\Command\GeneratorInterface $command */
    $command = $this->getHelperSet()->getCommand();

    $directory = $command->getDirectory();
    $extension_root = Utils::getExtensionRoot($directory);
    $this->baseDirectory = ($extension_root ?: $directory) . '/';

    $assets = $command->getAssets();

    $dumped_files = array_merge(
      $this->dumpFiles($assets['files']),
      $this->dumpHooks($assets['hooks']),
      $this->dumpServices($assets['services'], $extension_root)
    );

    $input->setInteractive($interactive);
    return $dumped_files;
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
        $question_text = sprintf('<info>The file <comment>%s</comment> already exists. Would you like to override it?</info> [<comment>Yes</comment>]: ', $file_path);
        if (!$this->askConfirmationQuestion($question_text)) {
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
   *
   * @todo Provide a method for dumping any kind of yml (not just services).
   */
  protected function dumpServices(array $services, $extension_root) {

    $dumped_files = [];

    $extension_name = basename($this->baseDirectory);

    $service_groups = [];

    // Sort services by type.
    foreach ($services as $service_name => $service) {
      if (isset($service['tags'])) {
        foreach ($service['tags'] as $tag) {

          switch ($tag['name']) {
            case 'drush.command':
              $service_groups['drush'][$service_name] = $service;
              break;

            case 'drupal.command':
              $service_groups['console'][$service_name] = $service;
              break;

            default:
              $service_groups[$extension_name][$service_name] = $service;
          }

        }
      }
    }

    foreach ($service_groups as $group_name => $group) {
      $inline = 3;

      $file = $this->baseDirectory . '/' . $group_name . '.services.yml';

      if ($this->filesystem->exists($file)) {
        $action = 'update';
        $intend = 2;
      }
      else {
        $this->services = ['services' => $group];
        $action = 'create';
        $intend = 0;
        $inline++;
      }

      $question_text = sprintf(
        '<info>Would you like to %s <comment>%s.services.yml</comment> file?</info> [<comment>Yes</comment>]: ',
        $action,
        $group_name
      );

      if ($this->askConfirmationQuestion($question_text)) {
        $yaml = $this->yamlDumper->dump($group, $inline, $intend);
        file_put_contents($file, $yaml, FILE_APPEND);
        $dumped_files[] = $group_name . '.services.yml';
      }

    }

    return $dumped_files;
  }

  /**
   * Asks user a confirmation question.
   *
   * @param string $question_text
   *   The question to ask to the user.
   *
   * @return bool
   *   User confirmation.
   */
  protected function askConfirmationQuestion($question_text) {
    // If the input is not interactive print the question with default answer.
    if ($this->override !== NULL) {
      $this->output->writeln($question_text . ($this->override ? 'Yes' : 'No'));
    }
    $question = new ConfirmationQuestion($question_text, $this->override !== FALSE);
    /** @var \Symfony\Component\Console\Helper\QuestionHelper $question_helper */
    $question_helper = $this->getHelperSet()->get('question');
    return $question_helper->ask($this->input, $this->output, $question);
  }

}

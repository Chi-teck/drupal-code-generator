<?php

namespace DrupalCodeGenerator\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Twig_Environment;

/**
 * Base class for all generators.
 */
abstract class BaseGenerator extends Command implements GeneratorInterface {

  /**
   * The command name.
   *
   * @var string
   */
  protected $name;

  /**
   * The command description.
   *
   * @var string
   */
  protected $description;

  /**
   * The command alias.
   */
  protected $alias;

  /**
   * List of files to create.
   *
   * The key of the each item in the array is the path to the file and
   * the value is the generated content of it.
   *
   * @var array
   */
  protected $files = [];

  /**
   * The file system utility.
   *
   * @var Filesystem
   */
  protected $filesystem;

  /**
   * The twig environment.
   *
   * @var Twig_Environment
   */
  protected $twig;

  /**
   * The base name of the current working directory.
   *
   * @var string
   */
  protected $directoryBaseName;

  /**
   * Constructs a generator command.
   */
  public function __construct(Filesystem $filesystem, Twig_Environment $twig) {
    parent::__construct();
    $this->filesystem = $filesystem;
    $this->twig = $twig;
    $this->directoryBaseName = basename(getcwd());
  }

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName($this->name)
      ->setDescription($this->description)
      ->addOption(
        'destination',
        '-d',
        InputOption::VALUE_OPTIONAL,
        'Destination directory'
      );

    if ($this->alias) {
      $this->setAliases([$this->alias]);
    }
  }

  /**
   * Renders file.
   *
   * @param string $template
   *   Twig template.
   * @param array $vars
   *   Template variables.
   *
   * @return string
   *   The rendered file.
   */
  protected function render($template, array $vars) {
    return $this->twig->render($template, $vars);
  }

  /**
   * Asks the user for template variables.
   *
   * @param InputInterface $input
   *   Input instance.
   * @param OutputInterface $output
   *   Output instance.
   * @param array $questions
   *   List of questions that the user should answer.
   *
   * @return array
   *   Template variables
   */
  protected function collectVars(InputInterface $input, OutputInterface $output, array $questions) {
    $vars = [];

    foreach ($questions as $name => $question) {
      list($question_text, $default_value) = $question;

      // Some default values match names of php functions.
      if (is_array($default_value) && is_callable($default_value)) {
        $default_value = call_user_func($default_value, $vars);
      }

      $vars[$name] = $this->ask(
        $input,
        $output,
        $question_text,
        $default_value,
        empty($question[2])
      );
    }

    return $vars;
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {

    $style = new OutputFormatterStyle('black', 'cyan', []);
    $output->getFormatter()->setStyle('title', $style);

    if (!$destination = $input->getOption('destination')) {
      $destination = $this->getExtensionRoot() ? $this->getExtensionRoot() : '.';
    }
    $destination .= '/';

    // Save files.
    foreach ($this->files as $file_path => $content) {

      $file_path = $destination . $file_path;
      if ($this->filesystem->exists($file_path)) {

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion(
          sprintf('<info>The file <comment>%s</comment> already exists. Would you like to override it?</info> [<comment>Yes</comment>]: ', $file_path),
          TRUE
        );

        if (!$helper->ask($input, $output, $question)) {
          $output->writeLn('Aborted.');
          return 0;
        }

      }
      try {
        // NULL means it is a directory.
        if ($content === NULL) {
          $this->filesystem->mkdir([$file_path], 0775);
          $directories_created = TRUE;
        }
        else {
          // Default mode for all parent directories is 0777. It can be
          // modified by the current umask, which you can change using umask().
          $this->filesystem->dumpFile($file_path, $content, 0644);
        }
      }
      catch (IOExceptionInterface $e) {
        $output->writeLn('<error>An error occurred while creating your file at ' . $e->getPath() . '</error>');
        return 1;
      }
    }

    $result_message = empty($directories_created) ?
      'The following files have been created:' :
      'The following files and directories have been created:';
    $output->writeLn("<title>$result_message</title>");
    foreach ($this->files as $name => $content) {
      $output->writeLn("- $name");
    }

    return 0;
  }

  /**
   * Asks a question to the user.
   *
   * @param InputInterface $input
   *   Input instance.
   * @param OutputInterface $output
   *   Output instance.
   * @param string $question_text
   *   The text of the question.
   * @param string $default_value
   *   Default value for the question.
   *
   * @return string
   *   The user anwser.
   */
  protected function ask(InputInterface $input, OutputInterface $output, $question_text, $default_value) {
    /** @var \Symfony\Component\Console\Helper\QuestionHelper $helper */
    $helper = $this->getHelper('question');

    $question_text = "<info>$question_text</info>";
    if ($default_value) {
      $question_text .= " [<comment>$default_value</comment>]";
    }
    $question_text .= ': ';

    if ($default_value == 'yes' || $default_value == 'no') {
      $question = new ConfirmationQuestion($question_text, $default_value == 'yes');
    }
    else {
      $question = new Question($question_text, $default_value);
    }

    return $helper->ask(
      $input,
      $output,
      $question
    );

  }

  /**
   * Returns extension root.
   *
   * @return string|bool
   *   Extension root directory or false if it wasn't found.
   */
  protected function getExtensionRoot() {
    static $extension_root;
    if ($extension_root === NULL) {
      $extension_root = FALSE;
      $directory = getcwd();
      for ($i = 1; $i <= 5; $i++) {
        $info_file = $directory . '/' . basename($directory) . '.info';
        if (file_exists($info_file) || file_exists($info_file . '.yml')) {
          $extension_root = $directory;
          break;
        }
        $directory = dirname($directory);
      }
    }
    return $extension_root;
  }

  /**
   * Creates file path.
   *
   * @TODO: Create a test for this.
   */
  protected function createPath($prefix, $path, $extension_machine_name) {
    if (basename($this->getExtensionRoot()) == $extension_machine_name) {
      $path = $prefix . $path;
    }
    return $path;
  }

  /**
   * Returns default value for the extension name question.
   */
  protected function defaultName() {
    return self::machine2human($this->getExtensionRoot() ? basename($this->getExtensionRoot()) : $this->directoryBaseName);
  }

  /**
   * Returns default value for the machine name question.
   */
  protected function defaultMachineName($vars) {
    return self::human2machine(isset($vars['name']) ? $vars['name'] : $this->directoryBaseName);
  }

  /**
   * Creates default plugin ID.
   */
  protected function defaultPluginId($vars) {
    return $vars['machine_name'] . '_' . $this->human2machine($vars['plugin_label']);
  }

  /**
   * Transforms a machine name to human name.
   */
  protected static function machine2human($machine_name) {
    return ucfirst(str_replace('_', ' ', $machine_name));
  }

  /**
   * Transforms a human name to machine name.
   */
  protected static function human2machine($human_name) {
    return preg_replace(
      ['/^[0-9]/', '/[^a-z0-9_]+/'],
      '_',
      strtolower($human_name)
    );
  }

  /**
   * Transforms a human name to PHP class name.
   */
  protected static function human2class($human_name) {
    return preg_replace(
      '/[^a-z0-9]/i',
      '',
      ucwords(str_replace('_', ' ', $human_name))
    );
  }

}

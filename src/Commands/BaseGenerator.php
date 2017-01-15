<?php

namespace DrupalCodeGenerator\Commands;

use DrupalCodeGenerator\TwigEnvironment;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Dumper;
use Twig_Environment;
use Twig_Loader_Filesystem;

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
   *
   * @var string
   */
  protected $alias;

  /**
   * Files to create.
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
   * @var \Symfony\Component\Filesystem\Filesystem
   */
  protected $filesystem;

  /**
   * The twig environment.
   *
   * @var \Twig_Environment
   */
  protected $twig;

  /**
   * The yaml dumper.
   *
   * @var \Symfony\Component\Yaml\Dumper
   */
  protected $yamlDumper;

  /**
   * The destination directory.
   *
   * @var string
   */
  protected $destination;

  /**
   * Services to dump.
   *
   * @var array
   */
  protected $services;

  /**
   * Hooks to dump.
   *
   * @var array
   */
  protected $hooks = [];

  /**
   * The level where you switch to inline YAML.
   *
   * @var int
   */
  protected $inline = 3;

  /**
   * Constructs a generator command.
   *
   * @param \Symfony\Component\Filesystem\Filesystem $filesystem
   *   The file system utility.
   * @param \Twig_Environment $twig
   *   The twig environment.
   * @param \Symfony\Component\Yaml\Dumper $yaml_dumper
   *   The yaml dumper.
   */
  public function __construct(Filesystem $filesystem, Twig_Environment $twig, Dumper $yaml_dumper) {
    parent::__construct();
    $this->filesystem = $filesystem;
    $this->twig = $twig;
    $this->yamlDumper = $yaml_dumper;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(array $twig_directories) {
    $file_system = new Filesystem();
    $twig_loader = new Twig_Loader_Filesystem($twig_directories);
    $twig = new TwigEnvironment($twig_loader);
    $yaml_dumper = new Dumper();
    $yaml_dumper->setIndentation(2);

    return new static(
      $file_system,
      $twig,
      $yaml_dumper
    );
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
      )
      ->addOption(
        'answers',
        '-a',
        InputOption::VALUE_OPTIONAL,
        'Default JSON formatted answers'
      );

    if ($this->alias) {
      $this->setAliases([$this->alias]);
    }
  }

  /**
   * Renders a template.
   *
   * @param string $template
   *   Twig template.
   * @param array $vars
   *   Template variables.
   *
   * @return string
   *   A string representing the rendered output.
   */
  protected function render($template, array $vars) {
    return $this->twig->render($template, $vars);
  }

  /**
   * Asks the user for template variables.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   Input instance.
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   Output instance.
   * @param array $questions
   *   List of questions that the user should answer.
   *
   * @return array
   *   Template variables
   */
  protected function collectVars(InputInterface $input, OutputInterface $output, array $questions) {
    $vars = [];

    // Input instance is not available in the constructor so we have to initiate
    // the destination here.
    $this->destination = $input->getOption('destination') ?
      Utils::normalizePath($input->getOption('destination')) : getcwd();

    if ($answers_raw = $input->getOption('answers')) {
      $answers = json_decode($answers_raw, TRUE);
      if (!is_array($answers)) {
        throw new InvalidOptionException('Answers should be encoded in JSON format.');
      }
    }

    foreach ($questions as $name => $question) {
      $question_text = $question[0];
      $default_value = isset($question[1]) ? $question[1] : NULL;
      $validator = isset($question[2]) ? $question[2] : NULL;
      $suggestions = isset($question[3]) ? $question[3] : NULL;
      $condition = isset($question[4]) ? $question[4] : NULL;

      // Make some assumptions based on question name.
      if ($default_value === NULL) {
        switch ($name) {
          // TODO: Test default values.
          case 'name':
            $directory = basename($this->getExtensionRoot() ?: $this->destination);
            $default_value = Utils::machine2human($directory);
            break;

          case 'machine_name':
            $default_value = function (array $vars) {
              return Utils::human2machine(isset($vars['name']) ? $vars['name'] : basename($this->destination));
            };
            break;

          case 'plugin_id':
            $default_value = [Utils::class, 'defaultPluginId'];
            break;
        }
      }

      if ($validator === NULL) {
        switch ($name) {
          // TODO: Test this validation.
          case 'machine_name':
          case 'plugin_id':
            $validator = [Utils::class, 'validateMachineName'];
            break;

          case 'class':
            $validator = [Utils::class, 'validateClassName'];
            break;

          // By default all values are required.
          default:
            $validator = [Utils::class, 'validateRequired'];
        }
      }

      if (is_callable($default_value)) {
        // Do not treat simple strings as callable because they may match PHP
        // builtin functions.
        if (!is_string($default_value) || strpos('::', $default_value) !== FALSE) {
          $default_value = call_user_func($default_value, $vars);
        }
      }

      $error = FALSE;
      do {
        // Do not ask if valid answer was passed through command line arguments.
        if (!$error && isset($answers[$name])) {
          $answer = $answers[$name];
        }
        else {
          // Check if this question should be skipped.
          if (is_callable($condition) && !$condition($vars)) {
            continue;
          }
          $answer = $this->ask(
            $input,
            $output,
            $question_text,
            $default_value,
            $suggestions
          );
        }

        if (is_callable($validator) && ($error = $validator($answer))) {
          $output->writeln('<error>' . $error . '</error>');
        }
      } while ($error);

      $vars[$name] = $answer;
    }

    return $vars;
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $style = new OutputFormatterStyle('black', 'cyan', []);
    $output->getFormatter()->setStyle('title', $style);

    $extension_root = $this->getExtensionRoot();
    $destination = ($extension_root ?: $this->destination) . '/';

    $dumped_files = [];

    // Dump files.
    foreach ($this->files as $file_name => $content) {
      $file_path = $destination . $file_name;
      if ($this->filesystem->exists($file_path)) {

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion(
          sprintf('<info>The file <comment>%s</comment> already exists. Would you like to override it?</info> [<comment>Yes</comment>]: ', $file_path),
          TRUE
        );

        if (!$helper->ask($input, $output, $question)) {
          continue;
        }

      }
      try {
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
      }
      catch (IOExceptionInterface $e) {
        $output->writeln('<error>An error occurred while creating your file at ' . $e->getPath() . '</error>');
        return 1;
      }

      $dumped_files[] = $file_name;
    }

    // Dump hooks.
    foreach ($this->hooks as $file_name => $hooks) {
      // TODO: Fix this.
      $hooks = isset($hooks[0]) ? $hooks : [$hooks];
      foreach ($hooks as $hook_info) {
        $file_path = $destination . $file_name;
        try {
          // If the file exists append hook code to it.
          if ($this->filesystem->exists($file_path)) {
            $original_content = file_get_contents($file_path);
            $content = $original_content . "\n" . $hook_info['code'];
            $files_updated = TRUE;
          }
          // Otherwise create a new file with provided file doc comment.
          else {
            $content = $hook_info['file_doc'] . "\n" . $hook_info['code'];
          }
          $this->filesystem->dumpFile($file_path, $content);
          $this->filesystem->chmod($file_path, 0644);
          $dumped_files[] = $file_name;
        }
        catch (IOExceptionInterface $exception) {
          $output->writeln('<error>An error occurred while creating your file at ' . $exception->getPath() . '</error>');
          return 1;
        }
      }
    }

    // Dump services.
    if ($this->services) {
      if ($extension_root) {
        $extension_name = basename($extension_root);
        $file = $extension_root . '/' . $extension_name . '.services.yml';

        if (file_exists($file)) {
          $action = 'update';
          $intend = 2;
        }
        else {
          $this->services = ['services' => $this->services];
          $action = 'create';
          $intend = 0;
          $this->inline++;
        }

        $question = new ConfirmationQuestion(
          sprintf(
            '<info>Would you like to %s <comment>%s.services.yml</comment> file?</info> [<comment>Yes</comment>]: ',
            $action,
            $extension_name
          ),
          TRUE
        );

        $helper = $this->getHelper('question');
        if ($helper->ask($input, $output, $question)) {
          $yaml = $this->yamlDumper->dump($this->services, $this->inline, $intend);
          file_put_contents($file, $yaml, FILE_APPEND);
          $dumped_files[] = $extension_name . '.services.yml';
        }
      }
    }

    // Multiple hooks can be dumped to the same file.
    $dumped_files = array_unique($dumped_files);
    if (count($dumped_files) > 0) {
      $output->writeln('<title>The following directories and files have been created or updated:</title>');
      foreach ($dumped_files as $file) {
        $output->writeln("- $file");
      }
    }

    return 0;
  }

  /**
   * Asks a question to the user.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   Input instance.
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   Output instance.
   * @param string $question_text
   *   The text of the question.
   * @param string $default_value
   *   Default value for the question.
   * @param array $suggestions
   *   (optional) Autocomplete values.
   *
   * @return string
   *   The user answer.
   */
  protected function ask(InputInterface $input, OutputInterface $output, $question_text, $default_value, array $suggestions = NULL) {
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

    if ($suggestions) {
      $question->setAutocompleterValues($suggestions);
    }

    $answer = $helper->ask(
      $input,
      $output,
      $question
    );

    return $answer;
  }

  /**
   * Returns extension root.
   *
   * @return string|bool
   *   Extension root directory or false if it was not found.
   */
  protected function getExtensionRoot() {
    static $extension_root;
    if ($extension_root === NULL) {
      $extension_root = FALSE;
      $directory = $this->destination;
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

}

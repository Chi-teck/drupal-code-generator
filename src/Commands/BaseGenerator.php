<?php

namespace DrupalCodeGenerator\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Twig_Loader_Filesystem;
use Twig_Environment;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

/**
 * Class BaseGenerator
 * @package DrupalCodeGenerator\Commands
 */
abstract class BaseGenerator extends Command {

  /**
   * @var
   */
  protected static $name;

  /**
   * @var
   */
  protected static $description;

  /**
   * @var array
   */
  protected $files = [];

  /**
   *
   */
  public function __construct() {
    parent::__construct();

    $twig_loader = new Twig_Loader_Filesystem(__DIR__ . '/../Resources/templates');
    $this->twig = new Twig_Environment($twig_loader);
    $this->fs = new Filesystem();
    $this->directoryBaseName = basename(getcwd());

  }

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName(static::$name)
      ->setDescription(static::$description)
      ->addOption(
        'dir',
        '-d',
        InputOption::VALUE_OPTIONAL,
        'Destination directory'
      );
  }

  /**
   * @param $template
   * @param array $vars
   * @return string
   */
  protected function render($template, array $vars) {
    return $this->twig->render($template, $vars);
  }

  /**
   * @param InputInterface $input
   * @param OutputInterface $output
   * @param array $questions
   * @return array
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

    $directory = $input->getOption('dir') ? $input->getOption('dir') . '/' : './';

    // Save files.
    foreach($this->files as $name => $content) {
      try {

        $this->fs->dumpFile($directory . $name, $content);
      }
      catch (IOExceptionInterface $e) {
        $output->writeLn('<error>An error occurred while creating your directory at ' . $e->getPath() . '</error>');
        return 1;
      }
    }

    $output->writeLn('<title>The following files have been created:</title>');
    foreach ($this->files as $name => $content) {
      $output->writeLn("- $name");
    }

    return 0;
  }

  /**
   * @param InputInterface $input
   * @param OutputInterface $output
   * @param $question_text
   * @param $default_value
   * @param bool $required
   * @return bool|mixed|null|string|void
   */
  protected function ask(InputInterface $input, OutputInterface $output, $question_text, $default_value, $required = FALSE) {
    /** @var \Symfony\Component\Console\Helper\QuestionHelper $helper */
    $helper = $this->getHelper('question');

    $question_text = "<info>$question_text</info>";
    if ($default_value) {
      $question_text .= " [<comment>$default_value</comment>]";
    }
    $question_text .= ': ';

    return $helper->ask(
      $input,
      $output,
      new Question($question_text, $default_value)
    );

  }

  /**
   * @param $vars
   * @return mixed
   */
  protected function defaultName($vars) {
    return self::machine2human($this->directoryBaseName);
  }

  /**
   * @param $vars
   * @return mixed
   */
  protected function defaultMachineName($vars) {
    return self::human2machine($vars['name']);
  }

  /**
   * @param $machine_name
   * @return string
   */
  protected static function machine2human($machine_name) {
    return ucfirst(str_replace('_', ' ', $machine_name));
  }

  /**
   * @param $human_name
   * @return mixed
   */
  protected static function human2machine($human_name) {
    return preg_replace(
      ['/^[0-9]/', '/[^a-z0-9_]+/'],
      '_',
      strtolower($human_name)
    );
  }

  /**
   * @param $human_name
   * @return mixed
   */
  protected static function human2class($human_name) {
    return preg_replace(
      '/[^a-z0-9]/i',
      '',
      ucwords(str_replace('_', ' ', $human_name))
    );
  }

}

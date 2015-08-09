<?php

namespace DrupalCodeGenerator\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Twig_Environment;

/**
 * Base class for all generators.
 */
abstract class BaseGenerator extends Command {

  protected static $name;
  protected static $description;
  protected $files = [];
  protected $filesystem;
  protected $twig;
  protected $directoryBaseName;
  protected $alias;

  /**
   * Constructs generator command
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
      ->setName(static::$name)
      ->setDescription(static::$description)
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
   * @param OutputInterface $output
   * @param array $questions
   *   Questions that the user should answer.
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

    $directory = $input->getOption('destination') ? $input->getOption('destination') . '/' : './';

    // Save files.
    foreach($this->files as $name => $content) {
      $file_path = $directory . $name;
      if ($this->filesystem->exists($file_path)) {

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion(
          sprintf('<info>The file <comment>%s</comment> already exists. Would you like to override it?</info> [<comment>Yes</comment>]: ', $name),
          TRUE
        );

        if (!$helper->ask($input, $output, $question)) {
          $output->writeLn('Aborted.');
          return 0;
        }

      }
      try {
        $this->filesystem->dumpFile($file_path, $content);
      }
      catch (IOExceptionInterface $e) {
        $output->writeLn('<error>An error occurred while creating your file at ' . $e->getPath() . '</error>');
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

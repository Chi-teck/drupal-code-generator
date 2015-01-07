<?php

namespace DrupalCodeGenerator\Command;

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

class BaseGenerator extends Command {

  protected  $core;

  public function __construct() {
    parent::__construct();

    $twig_loader = new Twig_Loader_Filesystem(DCG_ROOT_DIR . '/../src/Resources/templates');
    $this->twig = new Twig_Environment($twig_loader);
    $this->fs = new Filesystem();

  }

  protected function configure() {
    $this->addOption(
      'dir',
      '-d',
      InputOption::VALUE_OPTIONAL,
      'Destination directory'
    );
  }


  protected function render($template, array $vars) {
    return $this->twig->render($template, $vars);
  }

  protected function collectVars(InputInterface $input, OutputInterface $output, $keys, $question_prefix) {

    $question_prefix = ucfirst($question_prefix);

    /** @var \Symfony\Component\Console\Helper\QuestionHelper $helper */
    $helper = $this->getHelper('question');

    $vars = [];

    // Name question.
    if (in_array('name', $keys)) {
      $question = new Question("<info>$question_prefix name</info>: ");
      while (!$vars['name'] = $helper->ask($input, $output, $question));
    }

    // Machine name question.
    if (in_array('machine_name', $keys)) {
      $default_value =  $this->human2machine($vars['name']);
      $question = new Question(
        "<info>$question_prefix machine name</info> [<comment>$default_value</comment>]: ",
        $default_value
      );
      while (!$vars['machine_name'] = $helper->ask($input, $output, $question));

    }

    // Description question.
    if (in_array('description', $keys)) {
      $default_value = 'Some description';
      $question = new Question(
        "<info>$question_prefix description</info> [<comment>$default_value</comment>]: ",
        $default_value
      );
      $vars['description'] = $helper->ask($input, $output, $question);
    }

    // Package question.
    if (in_array('package', $keys)) {
      $default_value = 'custom';
      $question = new Question(
        "<info>$question_prefix package</info> [<comment>$default_value</comment>]: ",
        $default_value
      );
      $vars['package'] = $helper->ask($input, $output, $question);
    }

    // Package question.
    if (in_array('version', $keys)) {
      switch ($this->core) {
        case 6:
          $default_value = '6.x-1.0-dev';
          break;

        case 7:
          $default_value = '7.x-1.0-dev';
          break;

        case 8:
          $default_value = '8.x-1.0-dev';
          break;

        default:
          $default_value = '1.0-dev';

      }

      $question = new Question(
        "<info>$question_prefix version</info> [<comment>$default_value</comment>]: ",
        $default_value
      );
      $vars['version'] = $helper->ask($input, $output, $question);
    }

    return $vars;

  }

  protected  function human2machine($human_name) {
    return preg_replace(
      ['/^[0-9]/', '/[^a-z0-9_]+/'],
      '_',
      strtolower($human_name)
    );
  }

  protected function submitFiles(InputInterface $input, OutputInterface $output, $files) {

    var_dump($input->getOption('dir'));
    $directory = $input->getOption('dir') ? $input->getOption('dir') . '/' : './';

    foreach($files as $name => $content) {
      try {
        $this->fs->dumpFile($directory . $name, $content);
      }
      catch (IOExceptionInterface $e) {
        $output->writeLn('<error>An error occurred while creating your directory at ' . $e->getPath() . '</error>');
        exit(1);
      }
    }

    $output->writeLn('<title>The following files have been created:</title>');
    foreach ($files as $name => $content) {
      $output->writeLn("[<info>*</info>] $name");
    }

  }

}

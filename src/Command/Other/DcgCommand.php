<?php

namespace DrupalCodeGenerator\Command\Other;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements other:dcg-command command.
 */
class DcgCommand extends BaseGenerator {

  protected $name = 'other:dcg-command';
  protected $description = 'Generates DCG command';
  protected $alias = 'dcg-command';
  protected $label = 'DCG command';

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this->destination = Utils::getHomeDirectory() . '/.dcg/Command';
    parent::configure();
  }

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => new Question('Command name', 'custom:example'),
      'description' => new Question('Command description', 'Some description'),
      'alias' => new Question('Command alias', 'example'),
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $sub_names = explode(':', $vars['name']);
    $last_sub_name = array_pop($sub_names);
    $vars['class'] = Utils::camelize($last_sub_name);
    $vars['namespace'] = 'DrupalCodeGenerator\Command';
    $vars['template_name'] = $last_sub_name . '.twig';

    $vars['path'] = '';
    $file_path = '';
    if ($sub_names) {
      $vars['namespace'] .= '\\' . implode('\\', $sub_names);
      $file_path = implode(DIRECTORY_SEPARATOR, $sub_names);
      $vars['path'] = '/' . $file_path;
    }

    $class_path = $file_path . '/' . $vars['class'] . '.php';
    $this->setFile($class_path, 'other/dcg-command.twig', $vars);
    $template_path = $file_path . '/' . $vars['template_name'];
    $this->setFile($template_path, 'other/dcg-command-template.twig', $vars);
  }

}

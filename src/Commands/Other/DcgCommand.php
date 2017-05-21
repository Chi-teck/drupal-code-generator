<?php

namespace DrupalCodeGenerator\Commands\Other;

use DrupalCodeGenerator\Commands\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements other:dcg-command command.
 */
class DcgCommand extends BaseGenerator {

  protected $name = 'other:dcg-command';
  protected $description = 'Generates DCG command';
  protected $alias = 'dcg-command';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = [
      'name' => ['Command name', 'custom:example'],
      'description' => ['Command description', 'Some description'],
      'alias' => ['Command alias', 'example'],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $sub_names = explode(':', $vars['name']);
    $last_sub_name = array_pop($sub_names);
    $vars['class'] = Utils::camelize($last_sub_name);
    $vars['namespace'] = 'DrupalCodeGenerator\Commands';
    $file_path = $vars['class'] . '.php';
    $vars['path'] = '';
    if ($sub_names) {
      $vars['namespace'] .= '\\' . implode('\\', $sub_names);
      $file_path = implode(DIRECTORY_SEPARATOR, $sub_names) . '/' . $file_path;
      $vars['path'] = '/' . dirname($file_path);
    }

    $this->files[$file_path] = $this->render('other/dcg-command.twig', $vars);
  }

}

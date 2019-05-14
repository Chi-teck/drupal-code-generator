<?php

namespace DrupalCodeGenerator\Command\Other;

use DrupalCodeGenerator\Command\Generator;
use DrupalCodeGenerator\Utils;

/**
 * Implements other:dcg-command command.
 */
class DcgCommand extends Generator {

  protected $name = 'other:dcg-command';
  protected $description = 'Generates DCG command';
  protected $alias = 'dcg-command';
  protected $label = 'DCG command';

  /**
   * {@inheritdoc}
   */
  protected function configure() :void {
    $this->destination = Utils::getHomeDirectory() . '/.dcg/Command';
    parent::configure();
  }

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->vars;

    $vars['name'] = $this->ask('Command name', 'custom:example');
    $vars['description'] = $this->ask('Command description', 'Some description');
    $vars['alias'] = $this->ask('Command alias', 'example');

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

    $this->addFile($file_path . '/{class}.php', 'other/dcg-command');
    $this->addFile($file_path . '/{template_name}', 'other/dcg-command-template');
  }

}

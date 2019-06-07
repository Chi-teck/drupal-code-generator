<?php

namespace DrupalCodeGenerator\Command\Console;

use DrupalCodeGenerator\Command\Generator;
use DrupalCodeGenerator\Utils;

/**
 * Implements console:dcg-command command.
 */
final class DcgCommand extends Generator {

  protected $name = 'console:dcg-command';
  protected $description = 'Generates DCG command';
  protected $alias = 'dcg-command';
  protected $label = 'DCG command';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->vars;

    $command_name_validator = function (?string $value) :?string {
      return static::validate($value, '^[a-z][a-z0-9-_:]*[a-z0-9]$', 'The value is not correct command name.');
    };
    $vars['command_name'] = $this->ask('Command name', 'custom:example', $command_name_validator);

    $vars['description'] = $this->ask('Command description');

    $sub_names = explode(':', $vars['command_name']);
    $short_name = array_pop($sub_names);

    $alias_validator = function (?string $value) :?string {
      return static::validate($value, '^[a-z0-9][a-z0-9_]+$', 'The value is not correct alias name.');
    };
    $vars['alias'] = $this->ask('Command alias', $short_name, $alias_validator);

    $vars['class'] = Utils::camelize($short_name);
    $vars['namespace'] = 'DrupalCodeGenerator';
    $vars['template_name'] = $short_name;

    $vars['path'] = '';
    $file_path = '';
    if ($sub_names) {
      $vars['namespace'] .= '\\' . implode('\\', $sub_names);
      $file_path = implode(DIRECTORY_SEPARATOR, $sub_names);
      $vars['path'] = '/' . $file_path;
    }

    $this->addFile($file_path . '/{class}.php', 'command');
    $this->addFile($file_path . '/{template_name}.twig', 'template');
  }

}

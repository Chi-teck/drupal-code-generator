<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Console;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Utils;
use DrupalCodeGenerator\Validator\RegExp;

/**
 * Generates DCG command.
 *
 * @todo Clean-up.
 */
#[Generator(
  name: 'console:dcg-command',
  description: 'Generates DCG command',
  aliases: ['dcg-command'],
  // @todo Enable the generator once it is updated.
  hidden: TRUE,
  templatePath: Application::TEMPLATE_PATH . '/console/dcg-command',
  type: GeneratorType::MODULE_COMPONENT,
  label: 'DCG command',
)]
final class DcgCommand extends BaseGenerator {

  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);

    $command_name_validator = new RegExp('/^[a-z][a-z0-9-_:]*[a-z0-9]$/', 'The value is not correct command name.');
    $vars['command_name'] = $ir->ask('Command name', 'custom:example', $command_name_validator);

    $vars['description'] = $ir->ask('Command description');

    $sub_names = \explode(':', $vars['command_name']);
    $short_name = \array_pop($sub_names);

    $alias_validator = new RegExp('/^[a-z0-9][a-z0-9_]+$/', 'The value is not correct alias name.');
    $vars['alias'] = $ir->ask('Command alias', $short_name, $alias_validator);

    $vars['class'] = Utils::camelize($short_name);
    $vars['namespace'] = 'DrupalCodeGenerator';
    $vars['template_name'] = $short_name;

    $vars['path'] = '';
    $file_path = '';
    if ($sub_names) {
      $vars['namespace'] .= '\\' . \implode('\\', $sub_names);
      $file_path = \implode(\DIRECTORY_SEPARATOR, $sub_names);
      $vars['path'] = '/' . $file_path;
    }

    $assets->addFile($file_path . '/{class}.php', 'command.twig');
    $assets->addFile($file_path . '/{template_name}.twig', 'template.twig');
  }

}

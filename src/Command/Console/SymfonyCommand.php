<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Console;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Utils;
use DrupalCodeGenerator\Validator\RegExp;

// @todo Create SUT test for this.
#[Generator(
  name: 'console:symfony-command',
  description: 'Generates Symfony console command',
  aliases: ['symfony-command'],
  templatePath: Application::TEMPLATE_PATH . '/console/symfony-command',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class SymfonyCommand extends BaseGenerator {

  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);

    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();

    $command_name_validator = new RegExp('/^[a-z][a-z0-9-_:]*[a-z0-9]$/', 'The value is not correct command name.');
    $vars['command']['name'] = $ir->ask('Command name', '{machine_name}:example', $command_name_validator);

    $vars['command']['description'] = $ir->ask('Command description');

    $sub_names = \explode(':', $vars['command']['name']);
    $short_name = \array_pop($sub_names);

    $alias_validator = new RegExp('/^[a-z0-9][a-z0-9_]+$/', 'The value is not correct alias name.');
    $vars['command']['alias'] = $ir->ask('Command alias', $short_name, $alias_validator);

    $vars['class'] = $ir->ask('Class', Utils::camelize($short_name) . 'Command');

    if ($ir->confirm('Would you like to run the command with Drush')) {
      $assets->addServicesFile('drush.services.yml')->template('services.twig');
    }
    $assets->addFile('src/Command/{class}.php', 'command.twig');
  }

}

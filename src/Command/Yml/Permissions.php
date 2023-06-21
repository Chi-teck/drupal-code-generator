<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Validator\Required;

#[Generator(
  name: 'yml:permissions',
  description: 'Generates a permissions yml file',
  aliases: ['permissions', 'permissions.yml'],
  templatePath: Application::TEMPLATE_PATH . '/Yaml/_permissions',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Permissions extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);

    $vars['machine_name'] = $ir->askMachineName();

    $default_title = 'Administer {machine_name} configuration';
    $vars['permission_title'] = $ir->ask('Permission Title', $default_title, new Required());
    $vars['permission_id'] = $ir->askPermissionId();
    $vars['permission_description'] = $ir->ask('Permission description');
    $vars['restrict_access'] = $ir->confirm('Display warning about site security won the Permissions page?', $default = FALSE);

    $assets->addFile('{machine_name}.permissions.yml', 'permissions.twig');
  }

}

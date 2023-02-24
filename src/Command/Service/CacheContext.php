<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'service:cache-context',
  description: 'Generates a cache context service',
  aliases: ['cache-context'],
  templatePath: Application::TEMPLATE_PATH . '/Service/_cache-context',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class CacheContext extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();

    $vars['context_id'] = $ir->ask('Context ID', 'example');
    $vars['class'] = $ir->askClass(default: '{context_id|camelize}CacheContext');

    // @todo Clean-up.
    $base_class_choices = [
      '-',
      'RequestStackCacheContextBase',
      'UserCacheContextBase',
    ];
    $vars['base_class'] = $this->io()->choice('Base class', $base_class_choices);
    if ($vars['base_class'] === '-') {
      $vars['base_class'] = FALSE;
    }

    $vars['calculated'] = $ir->confirm('Make the context calculated?', FALSE);
    $vars['context_label'] = '{context_id|m2h}';

    $vars['interface'] = $vars['calculated'] ?
      'CalculatedCacheContextInterface' : 'CacheContextInterface';

    $assets->addFile('src/Cache/Context/{class}.php', 'cache-context.twig');
    $assets->addServicesFile()->template('services.twig');
  }

}

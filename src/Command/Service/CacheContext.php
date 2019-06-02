<?php

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:cache-context command.
 */
final class CacheContext extends ModuleGenerator {

  protected $name = 'service:cache-context';
  protected $description = 'Generates a cache context service';
  protected $alias = 'cache-context';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $vars['context_id'] = $this->ask('Context ID', 'example');
    $vars['class'] = $this->ask('Class', '{context_id|camelize}CacheContext');

    $base_class_choices = [
      '-',
      'RequestStackCacheContextBase',
      'UserCacheContextBase',
    ];
    $vars['base_class'] = $this->io->choice('Base class', $base_class_choices);
    if ($vars['base_class'] == '-') {
      $vars['base_class'] = FALSE;
    }

    $vars['calculated'] = $this->confirm('Make the context calculated?', FALSE);
    $vars['context_label'] = '{context_id|m2h}';

    $vars['interface'] = $vars['calculated'] ?
      'CalculatedCacheContextInterface' : 'CacheContextInterface';

    $this->addFile('src/Cache/Context/{class}.php', 'service/cache-context');
    $this->addServicesFile()
      ->template('service/cache-context.services');
  }

}

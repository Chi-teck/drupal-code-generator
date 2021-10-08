<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin;

/**
 * Implements plugin:block command.
 */
final class Block extends PluginGenerator {

  protected $name = 'plugin:block';
  protected $description = 'Generates block plugin';
  protected $alias = 'block';
  protected $pluginClassSuffix = 'Block';
  protected $pluginLabelQuestion = 'Block admin label';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);

    $vars['category'] = $this->ask('Block category', 'Custom');
    $vars['configurable'] = $this->confirm('Make the block configurable?', FALSE);

    $this->collectServices($vars, FALSE);

    $vars['access'] = $this->confirm('Create access callback?', FALSE);

    $this->addFile('src/Plugin/Block/{class}.php', 'block');

    if ($vars['configurable']) {
      $this->addSchemaFile()->template('schema');
    }
  }

}

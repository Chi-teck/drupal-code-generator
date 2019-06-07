<?php

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Asset;

/**
 * Implements template command.
 */
final class Template extends ModuleGenerator {

  protected $name = 'template';
  protected $description = 'Generates a template';
  protected $alias = 'template';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $vars['template_name'] = $this->ask('Template name', 'example');
    $vars['create_theme'] = $this->confirm('Create theme hook?');
    $vars['create_preprocess'] = $this->confirm('Create preprocess hook?');

    $this->addFile('templates/{template_name}.html.twig', 'template');

    if ($vars['create_theme'] || $vars['create_preprocess']) {
      $this->addFile('{machine_name}.module')
        ->template('module')
        ->action(Asset::APPEND)
        ->headerSize(7);
    }
  }

}

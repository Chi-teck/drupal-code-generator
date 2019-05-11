<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:template command.
 */
class Template extends ModuleGenerator {

  protected $name = 'd8:template';
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

    $this->addFile('templates/{template_name}.html.twig', 'd8/template-template');

    if ($vars['create_theme'] || $vars['create_preprocess']) {
      $this->addFile('{machine_name}.module')
        ->template('d8/template-module')
        ->action('append')
        ->headerSize(7);
    }
  }

}

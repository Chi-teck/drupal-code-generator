<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Field;

use DrupalCodeGenerator\Command\PluginGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:plugin:field:widget command.
 */
class Widget extends PluginGenerator {

  protected $name = 'd8:plugin:field:widget';
  protected $description = 'Generates field widget plugin';
  protected $alias = 'field-widget';
  protected $classSuffix = 'Widget';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) :void {
    $vars = &$this->collectDefault();
    $vars['configurable'] = $this->confirm('Make the widget configurable?', FALSE);

    $this->addFile()
      ->path('src/Plugin/Field/FieldWidget/{class}.php')
      ->template('d8/plugin/field/widget.twig');

    if ($vars['configurable']) {
      $this->addFile()
        ->path('config/schema/{machine_name}.schema.yml')
        ->template('d8/plugin/field/widget-schema.twig')
        ->action('append');
    }
  }

}

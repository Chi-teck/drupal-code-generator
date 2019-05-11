<?php

namespace DrupalCodeGenerator\Command\Drupal_7\CToolsPlugin;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Base class for d7:ctools-plugin commands.
 */
abstract class BasePlugin extends ModuleGenerator {

  protected $template;
  protected $subDirectory;

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $vars['plugin_name'] = $this->ask('Plugin name', 'Example', [Utils::class, 'validateRequired']);

    $vars['plugin_machine_name'] = $this->ask('Plugin machine name', '{plugin_name|h2m}', [Utils::class, 'validateMachineName']);

    $vars['description'] = $this->ask('Plugin description', 'Plugin description.');

    $vars['category'] = $this->ask('Category', 'Custom');

    $contexts = ['-', 'Node', 'User', 'Term'];
    $vars['context'] = $this->io->choice('Required context', $contexts);

    $this->addFile($this->subDirectory . '/{plugin_machine_name}.inc')
      ->template($this->template);
  }

}

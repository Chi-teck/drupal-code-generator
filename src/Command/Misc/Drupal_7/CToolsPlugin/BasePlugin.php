<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Misc\Drupal_7\CToolsPlugin;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Base class for misc:d7:ctools-plugin commands.
 */
abstract class BasePlugin extends ModuleGenerator {

  protected string $template;
  protected string $subDirectory;

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);

    $vars['plugin_name'] = $this->ask('Plugin name', 'Example', '::validateRequired');

    $vars['plugin_machine_name'] = $this->ask('Plugin machine name', '{plugin_name|h2m}', '::validateRequiredMachineName');

    $vars['description'] = $this->ask('Plugin description', 'Plugin description.');

    $vars['category'] = $this->ask('Category', 'Custom');

    $contexts = ['-', 'Node', 'User', 'Term'];
    $vars['context'] = $this->io->choice('Required context', $contexts);

    $this->addFile($this->subDirectory . '/{plugin_machine_name}.inc')
      ->template($this->template);
  }

}

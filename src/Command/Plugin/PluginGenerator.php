<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Base class for plugin generators.
 */
abstract class PluginGenerator extends ModuleGenerator {

  protected string $pluginClassSuffix = '';

  /**
   * {@inheritdoc}
   */
  protected function collectDefault(array &$vars): void {
    parent::collectDefault($vars);
    $vars['plugin_label'] = $this->askPluginLabelQuestion();
    $vars['plugin_id'] = $this->askPluginIdQuestion();
    $vars['class'] = $this->askPluginClassQuestion($vars);
  }

  /**
   * Asks plugin label question.
   */
  protected function askPluginLabelQuestion(): ?string {
    return $this->ask('Plugin label', 'Example', '::validateRequired');
  }

  /**
   * Asks plugin ID question.
   */
  protected function askPluginIdQuestion(): ?string {
    return $this->ask('Plugin ID', '{machine_name}_{plugin_label|h2m}', '::validateRequiredMachineName');
  }

  /**
   * Asks plugin class question.
   */
  protected function askPluginClassQuestion(array $vars): string {
    $unprefixed_plugin_id = \preg_replace('/^' . $vars['machine_name'] . '_/', '', $vars['plugin_id']);
    return $this->ask('Plugin class', Utils::camelize($unprefixed_plugin_id) . $this->pluginClassSuffix);
  }

}

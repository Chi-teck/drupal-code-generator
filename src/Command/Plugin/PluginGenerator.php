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
   * Plugin label question.
   *
   * @todo remove this.
   */
  protected ?string $pluginLabelQuestion = 'Plugin label';

  protected string $pluginLabelDefault = 'Example';

  /**
   * Plugin ID question.
   *
   * @todo remove this.
   */
  protected ?string $pluginIdQuestion = 'Plugin ID';

  protected string $pluginIdDefault = '{machine_name}_{plugin_label|h2m}';

  /**
   * Plugin class question.
   *
   * @todo remove this.
   */
  protected string $pluginClassQuestion = 'Plugin class';

  protected ?string $pluginClassDefault = NULL;

  /**
   * {@inheritdoc}
   */
  protected function collectDefault(array &$vars): void {
    parent::collectDefault($vars);
    if ($this->pluginLabelQuestion) {
      $vars['plugin_label'] = $this->askPluginLabelQuestion();
    }
    if ($this->pluginIdQuestion) {
      $vars['plugin_id'] = $this->askPluginIdQuestion();
    }
    if ($this->pluginClassQuestion) {
      $vars['class'] = $this->askPluginClassQuestion($vars);
    }
  }

  /**
   * Asks plugin label question.
   */
  protected function askPluginLabelQuestion(): string {
    return $this->ask($this->pluginLabelQuestion, $this->pluginLabelDefault, '::validateRequired');
  }

  /**
   * Asks plugin ID question.
   */
  protected function askPluginIdQuestion(): string {
    return $this->ask($this->pluginIdQuestion, $this->pluginIdDefault, '::validateRequiredMachineName');
  }

  /**
   * Asks plugin class question.
   */
  protected function askPluginClassQuestion(array $vars): string {
    if (!$this->pluginClassDefault) {
      $unprefixed_plugin_id = \preg_replace('/^' . $vars['machine_name'] . '_/', '', $vars['plugin_id']);
      $this->pluginClassDefault = Utils::camelize($unprefixed_plugin_id) . $this->pluginClassSuffix;
    }
    return $this->ask($this->pluginClassQuestion, $this->pluginClassDefault);
  }

}

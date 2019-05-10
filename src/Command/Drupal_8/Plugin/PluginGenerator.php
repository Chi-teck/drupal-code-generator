<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Utils;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Base class for plugin generators.
 */
abstract class PluginGenerator extends ModuleGenerator {

  protected $pluginClassSuffix = '';
  protected $pluginLabelQuestion = 'Plugin label';
  protected $pluginLabelDefault = 'Example';
  protected $pluginIdQuestion = 'Plugin ID';
  protected $pluginIdDefault;
  protected $pluginClassQuestion = 'Plugin class';
  protected $pluginClassDefault;

  /**
   * {@inheritdoc}
   */
  protected function &collectDefault() :array {
    parent::collectDefault();
    if ($this->pluginLabelQuestion) {
      $this->vars['plugin_label'] = $this->askPluginLabelQuestion();
    }
    if ($this->pluginIdQuestion) {
      $this->vars['plugin_id'] = $this->askPluginIdQuestion();
    }
    if ($this->pluginClassQuestion) {
      $this->vars['class'] = $this->askPluginClassQuestion();
    }
    return $this->vars;
  }

  /**
   * Asks plugin label question.
   */
  protected function askPluginLabelQuestion() :string {
    return $this->ask($this->pluginLabelQuestion, $this->pluginLabelDefault, [Utils::class, 'validateRequired']);
  }

  /**
   * Asks plugin ID question.
   */
  protected function askPluginIdQuestion() :string {
    if ($this->pluginIdDefault === NULL) {
      $this->pluginIdDefault = $this->vars['machine_name'] . '_' . Utils::human2machine($this->vars['plugin_label']);
    }
    return $this->ask($this->pluginIdQuestion, $this->pluginIdDefault, [Utils::class, 'validateMachineName']);
  }

  /**
   * Asks plugin class question.
   */
  protected function askPluginClassQuestion() :string {
    if (!$this->pluginClassDefault) {
      $unprefixed_plugin_id = preg_replace('/^' . $this->vars['machine_name'] . '_/', '', $this->vars['plugin_id']);
      $this->pluginClassDefault = Utils::camelize($unprefixed_plugin_id) . $this->pluginClassSuffix;
    }
    return $this->ask($this->pluginClassQuestion, $this->pluginClassDefault);
  }

}

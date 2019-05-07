<?php

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Utils;

/**
 * Base class for plugin generators.
 */
abstract class PluginGenerator extends ModuleGenerator {

  protected $classSuffix = '';
  protected $pluginLabelQuestion = 'Plugin label';
  protected $pluginLabelDefault = 'Example';
  protected $pluginIdQuestion = 'Plugin ID';
  protected $pluginIdDefault;

  /**
   * {@inheritdoc}
   */
  protected function &collectDefault() :array {
    parent::collectDefault();

    $vars = &$this->vars;

    if ($this->pluginLabelQuestion) {
      $vars['plugin_label'] = $this->ask(
        $this->pluginLabelQuestion,
        $this->pluginLabelDefault,
        [Utils::class, 'validateRequired']
      );
    }

    if ($this->pluginIdQuestion) {
      if ($this->pluginIdDefault === NULL) {
        $this->pluginIdDefault = $vars['machine_name'] . '_' . Utils::human2machine($vars['plugin_label']);
      }
      $vars['plugin_id'] = $this->ask(
        $this->pluginIdQuestion,
        $this->pluginIdDefault,
        [Utils::class, 'validateMachineName']
      );
    }

    $unprefixed_plugin_id = preg_replace('/^' . $this->vars['machine_name'] . '_/', '', $vars['plugin_id']);
    $default_class = Utils::camelize($unprefixed_plugin_id) . $this->classSuffix;
    $vars['class'] = $this->ask('Plugin class', $default_class);

    return $this->vars;
  }

}

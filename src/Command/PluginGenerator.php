<?php

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\Question;

/**
 * Base class for module generators.
 */
abstract class PluginGenerator extends ModuleGenerator {

  protected $classSuffix = '';
  protected $pluginLabelQuestion = 'Plugin label';
  protected $pluginLabelDefault = 'Example';
  protected $pluginIdQuestion = 'Plugin ID';
  protected $pluginIdDefault = [Utils::class, 'defaultPluginId'];

  /**
   * {@inheritdoc}
   */
  protected function &collectDefault() :array {
    parent::collectDefault();

    $questions = [];

    if ($this->pluginLabelQuestion) {
      $questions['plugin_label'] = new Question($this->pluginLabelQuestion, $this->pluginLabelDefault);
      $questions['plugin_label']->setValidator([Utils::class, 'validateRequired']);
    }

    if ($this->pluginIdQuestion) {
      $questions['plugin_id'] = new Question($this->pluginIdQuestion, $this->pluginIdDefault);
      $questions['plugin_id']->setValidator([Utils::class, 'validateMachineName']);
    }

    $vars = $this->collectVars($questions);

    $unprefixed_plugin_id = preg_replace('/^' . $vars['machine_name'] . '_/', '', $vars['plugin_id']);
    $default_class = Utils::camelize($unprefixed_plugin_id) . $this->classSuffix;
    $questions['class'] = new Question('Plugin class', $default_class);

    return $this->collectVars($questions);
  }

}

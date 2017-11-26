<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:plugin:ckeditor command.
 */
class CKEditor extends BaseGenerator {

  protected $name = 'd8:plugin:ckeditor';
  protected $description = 'Generates CKEditor plugin';
  protected $alias = 'ckeditor';
  protected $label = 'CKEditor';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultPluginQuestions();

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize($vars['plugin_label']);

    $unprefixed_plugin_id = preg_replace('/^' . $vars['machine_name'] . '_/', '', $vars['plugin_id']);

    // Convert plugin ID to hyphen case.
    $vars['short_plugin_id'] = str_replace('_', '-', $unprefixed_plugin_id);
    $vars['command_name'] = Utils::camelize($unprefixed_plugin_id, FALSE);

    $this->setFile(
      'src/Plugin/CKEditorPlugin/' . $vars['class'] . '.php',
      'd8/plugin/_ckeditor/ckeditor.twig',
      $vars
    );

    $this->setFile(
      "js/plugins/{$vars['short_plugin_id']}/plugin.js",
      'd8/plugin/_ckeditor/plugin.twig',
      $vars
    );

    $this->setFile(
      "js/plugins/{$vars['short_plugin_id']}/dialogs/{$vars['short_plugin_id']}.js",
      'd8/plugin/_ckeditor/dialog.twig',
      $vars
    );

    $this->files["js/plugins/{$vars['short_plugin_id']}/icons/{$vars['short_plugin_id']}.png"] = [
      'content' => file_get_contents($this->templatePath . '/d8/plugin/_ckeditor/icon.png'),
      'action' => 'replace',
    ];

  }

}

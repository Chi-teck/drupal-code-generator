<?php

namespace Drupal\foo\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginBase;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "Example" plugin.
 *
 * @CKEditorPlugin(
 *   id = "foo_example",
 *   label = @Translation("Example"),
 *   module = "foo"
 * )
 */
class Example extends CKEditorPluginBase {

  /**
   * {@inheritdoc}
   */
  public function getFile() {
    return drupal_get_path('module', 'foo') . '/js/plugins/example/plugin.js';
  }

  /**
   * {@inheritdoc}
   */
  public function getConfig(Editor $editor) {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    $module_path = drupal_get_path('module', 'foo');
    return [
      'example' => [
        'label' => $this->t('Example'),
        'image' => $module_path . '/js/plugins/example/icons/example.png',
      ],
    ];
  }

}

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
    return $this->getModulePath('foo') . '/js/plugins/example/plugin.js';
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
    return [
      'example' => [
        'label' => $this->t('Example'),
        'image' => $this->getModulePath('foo') . '/js/plugins/example/icons/example.png',
      ],
    ];
  }

}

<?php

namespace Drupal\example\Plugin\Action;

use Drupal\Core\Action\ConfigurableActionBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a a Foo action.
 *
 * @Action(
 *   id = "example_foo",
 *   label =  @Translation("Foo"),
 *   type = "node",
 *   category = @Translation("Custom")
 * )
 */
class Foo extends ConfigurableActionBase {

  /**
   * {@inheritdoc}
   */
  public function execute($node = NULL) {
    /** @var \Drupal\node\NodeInterface $node */
    $node->setTitle($this->configuration['title'])->save();
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['title' => ''];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form['title'] = array(
      '#title' => t('New title'),
      '#type' => 'textfield',
      '#required' => TRUE,
      '#default_value' => $this->configuration['title'],
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['title'] = $form_state->getValue('title');
  }

  /**
   * {@inheritdoc}
   */
  public function access($node, AccountInterface $account = NULL, $return_as_object = FALSE) {
    /** @var \Drupal\node\NodeInterface $node */
    $access = $node->access('update', $account, TRUE)
      ->andIf($node->title->access('edit', $account, TRUE));

    return $return_as_object ? $access : $access->isAllowed();
  }

}

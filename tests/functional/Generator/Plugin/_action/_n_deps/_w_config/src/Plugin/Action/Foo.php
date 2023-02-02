<?php declare(strict_types = 1);

namespace Drupal\example\Plugin\Action;

use Drupal\Core\Access\AccessResultInterface;
use Drupal\Core\Action\ConfigurableActionBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a Foo action.
 *
 * @Action(
 *   id = "example_foo",
 *   label = @Translation("Foo"),
 *   type = "node",
 *   category = @Translation("Custom"),
 * )
 *
 * @DCG
 * For updating entity fields consider extending FieldUpdateActionBase.
 * @see \Drupal\Core\Field\FieldUpdateActionBase
 *
 * @DCG
 * In order to set up the action through admin interface the plugin has to be
 * configurable.
 * @see https://www.drupal.org/project/drupal/issues/2815301
 * @see https://www.drupal.org/project/drupal/issues/2815297
 *
 * @DCG
 * The whole action API is subject of change.
 * @see https://www.drupal.org/project/drupal/issues/2011038
 */
final class Foo extends ConfigurableActionBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration(): array {
    return ['example' => ''];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state): array {
    $form['example'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Example'),
      '#default_value' => $this->configuration['example'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state): void {
    $this->configuration['example'] = $form_state->getValue('example');
  }

  /**
   * {@inheritdoc}
   */
  public function access($entity, AccountInterface $account = NULL, $return_as_object = FALSE): AccessResultInterface|bool {
    /** @var \Drupal\Core\Entity\ContentEntityInterface $entity */
    $access = $entity->access('update', $account, TRUE)
      ->andIf($entity->get('field_example')->access('edit', $account, TRUE));
    return $return_as_object ? $access : $access->isAllowed();
  }

  /**
   * {@inheritdoc}
   */
  public function execute(ContentEntityInterface $entity = NULL): void {
    $entity->set('field_example', 'New value')->save();
  }

}

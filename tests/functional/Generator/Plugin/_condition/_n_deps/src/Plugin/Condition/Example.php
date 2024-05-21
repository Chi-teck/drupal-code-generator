<?php

declare(strict_types=1);

namespace Drupal\foo\Plugin\Condition;

use Drupal\Core\Condition\Attribute\Condition;
use Drupal\Core\Condition\ConditionPluginBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Provides a 'Example' condition.
 */
#[Condition(
  id: 'foo_example',
  label: new TranslatableMarkup('Example'),
)]
final class Example extends ConditionPluginBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration(): array {
    return ['example' => ''] + parent::defaultConfiguration();
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
    return parent::buildConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state): void {
    $this->configuration['example'] = $form_state->getValue('example');
    parent::submitConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function summary(): string {
    return (string) $this->t(
      'Example: @example', ['@example' => $this->configuration['example']],
    );
  }

  /**
   * {@inheritdoc}
   */
  public function evaluate(): bool {
    // @todo Evaluate the condition here.
    return TRUE;
  }

}

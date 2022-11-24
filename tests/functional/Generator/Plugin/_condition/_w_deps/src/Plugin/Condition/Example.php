<?php declare(strict_types = 1);

namespace Drupal\foo\Plugin\Condition;

use Drupal\Core\Condition\ConditionPluginBase;
use Drupal\Core\CronInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Example' condition.
 *
 * @Condition(
 *   id = "foo_example",
 *   label = @Translation("Example"),
 * )
 */
final class Example extends ConditionPluginBase implements ContainerFactoryPluginInterface {

  /**
   * Constructs a new Example instance.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    private readonly CronInterface $cron,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): self {
    return new self(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('cron'),
    );
  }

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

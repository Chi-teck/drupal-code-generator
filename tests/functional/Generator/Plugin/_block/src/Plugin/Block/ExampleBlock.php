<?php

namespace Drupal\foo\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\CronInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "foo_example",
 *   admin_label = @Translation("Example"),
 *   category = @Translation("Custom")
 * )
 */
class ExampleBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The cron service.
   *
   * @var \Drupal\Core\CronInterface
   */
  protected $cron;

  /**
   * Constructs a new ExampleBlock instance.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, CronInterface $cron) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->cron = $cron;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): static {
    return new static(
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
    return [
      'example' => $this->t('Hello world!'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state): array {
    $form['example'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Example'),
      '#default_value' => $this->configuration['example'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state): void {
    $this->configuration['example'] = $form_state->getValue('example');
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account): AccessResult {
    // @todo Evaluate the access condition here.
    return AccessResult::allowedIf(TRUE);
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $build['content'] = [
      '#markup' => $this->t('It works!'),
    ];
    return $build;
  }

}

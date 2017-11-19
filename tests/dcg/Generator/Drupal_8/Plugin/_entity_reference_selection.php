<?php

namespace Drupal\example\Plugin\EntityReferenceSelection;

use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Plugin\EntityReferenceSelection\NodeSelection;

/**
 * Plugin description.
 *
 * @EntityReferenceSelection(
 *   id = "example_advanced_node_selection",
 *   label = @Translation("Advanced node selection"),
 *   group = "example_advanced_node_selection",
 *   entity_types = {"node"},
 *   weight = 0
 * )
 */
class ExampleNodeSelection extends NodeSelection {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {

    $default_configuration = [
      'foo' => 'bar',
    ];

    return $default_configuration + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);

    $form['foo'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Foo'),
      '#default_value' => $this->configuration['foo'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  protected function buildEntityQuery($match = NULL, $match_operator = 'CONTAINS') {
    $query = parent::buildEntityQuery($match, $match_operator);

    // @DCG
    // Here you can apply addition conditions, sorting, etc to the query.
    // Also see self::entityQueryAlter().
    $query->condition('field_example', 123);

    return $query;
  }

}

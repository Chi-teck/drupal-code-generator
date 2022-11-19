<?php declare(strict_types = 1);

namespace Drupal\example\Plugin\EntityReferenceSelection;

use Drupal\Core\Entity\Query\QueryInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Plugin\EntityReferenceSelection\NodeSelection;

/**
 * @todo Add plugin description here.
 *
 * @EntityReferenceSelection(
 *   id = "example_node_selection",
 *   label = @Translation("Advanced node selection"),
 *   group = "example_node_selection",
 *   entity_types = {"node"},
 * )
 */
final class ExampleNodeSelection extends NodeSelection {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration(): array {
    $default_configuration = [
      'foo' => 'bar',
    ];
    return $default_configuration + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state): array {
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
  protected function buildEntityQuery($match = NULL, $match_operator = 'CONTAINS'): QueryInterface {
    $query = parent::buildEntityQuery($match, $match_operator);
    // @todo Modify the query here.
    return $query;
  }

}

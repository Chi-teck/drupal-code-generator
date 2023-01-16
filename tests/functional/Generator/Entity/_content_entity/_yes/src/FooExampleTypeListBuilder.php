<?php declare(strict_types = 1);

namespace Drupal\foo;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of example type entities.
 *
 * @see \Drupal\foo\Entity\FooExampleType
 */
final class FooExampleTypeListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['label'] = $this->t('Label');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    $row['label'] = $entity->label();
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render(): array {
    $build = parent::render();

    $build['table']['#empty'] = $this->t(
      'No example types available. <a href=":link">Add example type</a>.',
      [':link' => Url::fromRoute('entity.foo_example_type.add_form')->toString()],
    );

    return $build;
  }

}

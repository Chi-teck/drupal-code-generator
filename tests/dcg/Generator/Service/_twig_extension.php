<?php

namespace Drupal\example;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;

/**
 * Twig extension.
 */
class ExampleTwigExtension extends AbstractExtension {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new ExampleTwigExtension object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function getFunctions() {
    return [
      new TwigFunction('foo', function ($argument = NULL) {
        return 'Foo: ' . $argument;
      }),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFilters() {
    return [
      new TwigFilter('bar', function ($text) {
        return str_replace('bar', 'BAR', $text);
      }),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getTests() {
    return [
      new TwigTest('color', function ($text) {
        return preg_match('/^#(?:[0-9a-f]{3}){1,2}$/i', $text);
      }),
    ];
  }

}

<?php

namespace Drupal\example;

use Drupal\Core\Database\Connection;
use Drupal\Core\ParamConverter\ParamConverterInterface;
use Symfony\Component\Routing\Route;

/**
 * Converts parameters for upcasting database record IDs to full std objects.
 *
 * @DCG: {
 * In order to use it you should specify some additional options in your route:
 * @code
 * example.foo_parameter_converter:
 *   path: example/{record}
 *   defaults:
 *     _controller: '\Drupal\example\Controller\ExampleController:build'
 *   requirements:
 *     _access: 'TRUE'
 *   options:
 *     parameters:
 *       record:
 *        type: foo
 * @endcode
 *
 * Note that for entities you can make use of existing parameter converter
 * provided by Drupal core.
 * @see \Drupal\Core\ParamConverter\EntityConverter;
 * @DCG: }
 */
class FooParamConverter implements ParamConverterInterface {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * Constructs a new FooParamConverter.
   *
   * @param \Drupal\Core\Database\Connection $connection
   *   The default database connection.
   */
  public function __construct(Connection $connection) {
    $this->connection = $connection;
  }

  /**
   * {@inheritdoc}
   */
  public function convert($value, $definition, $name, array $defaults) {
    // Return NULL if record not found to trigger 404 HTTP error.
    return $this->connection->query('SELECT * FROM {table_name} WHERE id = ?', [$value])->fetch() ?: NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function applies($definition, $name, Route $route) {
    return !empty($definition['type']) && $definition['type'] == 'foo';
  }

}

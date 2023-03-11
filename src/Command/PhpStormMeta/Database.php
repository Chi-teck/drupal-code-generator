<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\PhpStormMeta;

use Drupal\Core\Database\Connection;
use DrupalCodeGenerator\Asset\File;

/**
 * Generates PhpStorm meta-data for Drupal database.
 */
final class Database {

  /**
   * Constructs the object.
   */
  public function __construct(
    private readonly Connection $connection,
  ) {}

  /**
   * Generator callback.
   */
  public function __invoke(): File {
    $driver = $this->connection->driver();
    $tables = [];
    // @todo Support PostgreSQL.
    if ($driver === 'mysql') {
      /** @psalm-suppress PossiblyNullReference, PossiblyInvalidMethodCall */
      $tables = $this->connection->query('SHOW TABLES')->fetchCol();
    }
    elseif ($driver === 'sqlite') {
      $query = <<< 'SQL'
        SELECT name
        FROM sqlite_schema
        WHERE type ='table' AND name NOT LIKE 'sqlite_%'
        ORDER BY name
        SQL;
      /** @psalm-suppress PossiblyNullReference, PossiblyInvalidMethodCall */
      $tables = $this->connection->query($query)->fetchCol();
    }
    return File::create('.phpstorm.meta.php/database.php')
      ->template('database.php.twig')
      ->vars(['tables' => $tables]);
  }

}

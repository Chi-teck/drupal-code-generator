<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Base class for DCG tests.
 *
 * @package DrupalCodeGenerator\Tests
 */
abstract class BaseTestCase extends TestCase {

  /**
   * Working directory.
   *
   * @var string
   */
  protected string $directory;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    $this->directory = \sys_get_temp_dir() . '/dcg_sandbox';
  }

  /**
   * {@inheritdoc}
   */
  public function tearDown(): void {
    (new Filesystem())->remove($this->directory);
  }

}

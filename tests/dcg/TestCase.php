<?php

namespace DrupalCodeGenerator\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Base class for DCG tests.
 *
 * @package DrupalCodeGenerator\Tests
 */
abstract class TestCase extends BaseTestCase {

  /**
   * Working directory.
   *
   * @var string
   */
  protected $directory;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->directory = sys_get_temp_dir() . '/dcg_sandbox';
  }

  /**
   * {@inheritdoc}
   */
  public function tearDown() {
    (new Filesystem())->remove($this->directory);
  }

}

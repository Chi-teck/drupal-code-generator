<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\ClassResolver\SimpleClassResolver;
use PHPUnit\Framework\TestCase;

/**
 * A test for SimpleClassResolver.
 */
final class SimpleClassResolverTest extends TestCase {

  /**
   * Test callback.
   */
  public function testSimpleClassResolver(): void {

    $resolver = new SimpleClassResolver();

    $object = $resolver->getInstance(\stdClass::class);
    self::assertInstanceOf(\stdClass::class, $object);

    $object = $resolver->getInstance(Application::class);
    self::assertInstanceOf(Application::class, $object);

    $this->expectException(\InvalidArgumentException::class);
    $resolver->getInstance('MissingClass');
  }

}

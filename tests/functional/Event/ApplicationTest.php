<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Event;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Test\Functional\FunctionalTestBase;

/**
 * Test application event.
 */
final class ApplicationTest extends FunctionalTestBase {

  /**
   * Test callback.
   */
  public function testApplication(): void {
    $listener = static function (Application $application): void {
      $application->setVersion('Premium edition');
    };

    $container = self::bootstrap();
    $container
      ->get('event_dispatcher')
      ->addListener(Application::class, $listener);

    $application = self::createApplication($container);

    self::assertSame('Premium edition', $application->getVersion());
  }

}

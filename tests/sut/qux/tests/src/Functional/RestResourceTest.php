<?php

declare(strict_types=1);

namespace Drupal\Tests\qux\Functional;

use Drupal\Core\Url;
use Drupal\Tests\rest\Functional\CookieResourceTestTrait;
use Drupal\Tests\rest\Functional\ResourceTestBase;
use Drupal\user\Entity\Role;
use Drupal\user\RoleInterface;
use GuzzleHttp\RequestOptions;

/**
 * Test REST resource.
 *
 * @group DCG
 */
final class RestResourceTest extends ResourceTestBase {

  use CookieResourceTestTrait;

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected static $resourceConfigId = 'qux_example';

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['rest', 'qux'];

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();
    $this->provisionResource([self::$format], ['cookie']);
    $user_role = Role::load(RoleInterface::ANONYMOUS_ID);
    $permissions = [
      'restful get qux_example',
      'restful post qux_example',
      'restful patch qux_example',
      'restful delete qux_example',
    ];
    $user_role->set('permissions', $permissions);
    $user_role->save();
  }

  /**
   * Test callback.
   */
  public function testResource(): void {

    $route_prefix = 'rest.' . self::$resourceConfigId . '.';

    // -- POST method.
    $record_encoded = '{"title":"Alpha","price":125}';
    $request_options = [
      RequestOptions::BODY => $record_encoded,
      RequestOptions::HEADERS => ['Content-Type' => self::$mimeType],
    ];
    $url = Url::fromRoute($route_prefix . 'POST', ['_format' => self::$format]);
    $response = $this->request('POST', $url, $request_options);

    self::assertSame(201, $response->getStatusCode());
    $expected_body = '{"title":"Alpha","price":125,"id":1}';
    self::assertSame($expected_body, (string) $response->getBody());

    // -- GET method.
    $url = Url::fromRoute(
      $route_prefix . 'GET',
      ['id' => 1, '_format' => self::$format],
    );
    $response = $this->request('GET', $url, []);

    self::assertSame(200, $response->getStatusCode());
    $expected_body = '{"title":"Alpha","price":125,"id":1}';
    self::assertSame($expected_body, (string) $response->getBody());

    // A request for non-existing record should return 404.
    $url = Url::fromRoute(
      $route_prefix . 'GET',
      ['id' => 100, '_format' => self::$format],
    );
    $response = $this->request('GET', $url, []);
    self::assertSame(404, $response->getStatusCode());

    // -- PATCH method.
    $record_encoded = '{"title":"Alpha patched"}';
    $request_options[RequestOptions::BODY] = $record_encoded;
    $url = Url::fromRoute(
      $route_prefix . 'PATCH',
      ['id' => 1, '_format' => self::$format],
    );
    $response = $this->request('PATCH', $url, $request_options);

    self::assertSame(200, $response->getStatusCode());
    $expected_body = '{"title":"Alpha patched","price":125,"id":1}';
    self::assertSame($expected_body, (string) $response->getBody());

    // -- DELETE method.
    $url = Url::fromRoute($route_prefix . 'DELETE', ['id' => 1]);
    $response = $this->request('DELETE', $url, []);

    self::assertSame(204, $response->getStatusCode());
    self::assertSame('', (string) $response->getBody());
  }

  /**
   * {@inheritdoc}
   */
  protected function setUpAuthorization($method) {
    // Intentionally empty.
  }

  /**
   * {@inheritdoc}
   */
  protected function assertNormalizationEdgeCases($method, Url $url, array $request_options) {
    // Intentionally empty.
  }

  /**
   * {@inheritdoc}
   */
  protected function getExpectedUnauthorizedAccessMessage($method) {
    // Intentionally empty.
  }

  /**
   * {@inheritdoc}
   */
  protected function getExpectedUnauthorizedAccessCacheability() {
    // Intentionally empty.
  }

}

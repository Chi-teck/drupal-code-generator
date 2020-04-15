<?php

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
class RestResourceTest extends ResourceTestBase {

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
  public static $modules = ['rest', 'qux'];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    $this->provisionResource([static::$format], ['cookie']);

    $user_role = Role::load(RoleInterface::ANONYMOUS_ID);
    $permissions = [
      'restful get qux_example',
      'restful post qux_example',
      'restful patch qux_example',
      'restful put qux_example',
      'restful delete qux_example',
    ];
    $user_role->set('permissions', $permissions);
    $user_role->save();

    $table_schema = [
      'fields' => [
        'id' => [
          'type' => 'serial',
          'unsigned' => TRUE,
          'not null' => TRUE,
        ],
        'title' => [
          'type' => 'varchar',
          'length' => 255,
          'not null' => TRUE,
        ],
        'description' => [
          'type' => 'varchar',
          'length' => 255,
          'not null' => FALSE,
        ],
        'price' => [
          'type' => 'int',
          'unsigned' => TRUE,
          'not null' => FALSE,
        ],
      ],
      'primary key' => ['id'],
    ];

    $db_connection = \Drupal::database();

    $db_connection
      ->schema()
      ->createTable('qux_example', $table_schema);

    $db_connection->insert('qux_example')
      ->fields(['title', 'description', 'price'])
      ->values(['Alpha', 'Some description', 10])
      ->execute();
  }

  /**
   * Test callback.
   */
  public function testResource() {

    $route_prefix = 'rest.' . self::$resourceConfigId . '.';

    // -- Test GET method.
    $method = 'GET';
    $url = Url::fromRoute($route_prefix . $method, ['id' => 1, '_format' => self::$format]);
    $response = $this->request($method, $url, []);

    self::assertEquals(200, $response->getStatusCode());
    $expected_body = '{"id":"1","title":"Alpha","description":"Some description","price":"10"}';
    self::assertEquals($expected_body, $response->getBody());

    // Request for non existing record should return 404.
    $url = Url::fromRoute($route_prefix . $method, ['id' => 100, '_format' => self::$format]);
    $response = $this->request($method, $url, []);
    self::assertEquals(404, $response->getStatusCode());

    // -- Test POST method.
    $method = 'POST';
    $record_encoded = '{"title":"Beta","description":"Some description","price":"125"}';
    $request_options = [
      RequestOptions::BODY => $record_encoded,
      RequestOptions::HEADERS => ['Content-Type' => self::$mimeType],
    ];
    $url = Url::fromRoute($route_prefix . $method, ['_format' => self::$format]);
    $response = $this->request($method, $url, $request_options);

    self::assertEquals(201, $response->getStatusCode());
    $expected_body = '{"id":"2","title":"Beta","description":"Some description","price":"125"}';
    self::assertEquals($expected_body, $response->getBody());

    // -- Test data validation.
    // Wrong data type.
    $request_options[RequestOptions::BODY] = 123;
    $url = Url::fromRoute($route_prefix . $method, ['_format' => self::$format]);
    $response = $this->request($method, $url, $request_options);

    self::assertEquals(400, $response->getStatusCode());
    $expected_body = '{"message":"No record content received."}';
    self::assertEquals($expected_body, $response->getBody());

    // Unexpected property.
    $request_options[RequestOptions::BODY] = '{"foo": "bar"}';
    $url = Url::fromRoute($route_prefix . $method, ['_format' => self::$format]);
    $response = $this->request($method, $url, $request_options);

    self::assertEquals(400, $response->getStatusCode());
    $expected_body = '{"message":"Record structure is not correct."}';
    self::assertEquals($expected_body, $response->getBody());

    // Missing title.
    $request_options[RequestOptions::BODY] = '{"description": "Some description"}';
    $url = Url::fromRoute($route_prefix . $method, ['_format' => self::$format]);
    $response = $this->request($method, $url, $request_options);

    self::assertEquals(400, $response->getStatusCode());
    $expected_body = '{"message":"Title is required."}';
    self::assertEquals($expected_body, $response->getBody());

    // Too big title.
    $request_options[RequestOptions::BODY] = json_encode(['title' => str_repeat('x', 256)]);
    $url = Url::fromRoute($route_prefix . $method, ['_format' => self::$format]);
    $response = $this->request($method, $url, $request_options);

    self::assertEquals(400, $response->getStatusCode());
    $expected_body = '{"message":"Title is too big."}';
    self::assertEquals($expected_body, $response->getBody());

    // -- Test PATCH method.
    $method = 'PATCH';
    $record_encoded = '{"title":"Alpha patched"}';
    $request_options[RequestOptions::BODY] = $record_encoded;
    $url = Url::fromRoute($route_prefix . $method, ['id' => 1, '_format' => self::$format]);
    $response = $this->request($method, $url, $request_options);

    self::assertEquals(200, $response->getStatusCode());
    $expected_body = '{"id":"1","title":"Alpha patched","description":"Some description","price":"10"}';
    self::assertEquals($expected_body, $response->getBody());

    // -- Test DELETE method.
    $method = 'DELETE';
    $url = Url::fromRoute($route_prefix . $method, ['id' => 1]);
    $response = $this->request($method, $url, []);

    self::assertEquals(204, $response->getStatusCode());
    self::assertEquals('', $response->getBody());
  }

  /**
   * {@inheritdoc}
   */
  protected function setUpAuthorization($method) {}

  /**
   * {@inheritdoc}
   */
  protected function assertNormalizationEdgeCases($method, Url $url, array $request_options) {}

  /**
   * {@inheritdoc}
   */
  protected function getExpectedUnauthorizedAccessMessage($method) {}

  /**
   * {@inheritdoc}
   */
  protected function getExpectedUnauthorizedAccessCacheability() {}

}

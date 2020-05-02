<?php

namespace DrupalCodeGenerator\Tests\Generator;

use DrupalCodeGenerator\Command\PhpStormMetadata;
use DrupalCodeGenerator\GeneratorTester;
use DrupalCodeGenerator\Helper\DrupalContext;

/**
 * Test for phpstorm-metadata command.
 */
final class PhpStormMetadataTest extends BaseGeneratorTest {

  /**
   * A generator to be tested.
   *
   * @var \DrupalCodeGenerator\Command\PhpStormMetadata
   */
  private $generator;

  /**
   * {@inheritdoc}
   */
  public function setUp() : void {

    parent::setUp();

    $code = <<< 'CODE'
    namespace Symfony\Component\DependencyInjection;
    interface ContainerInterface {
      public function get();
    }
    CODE;
    // phpcs:ignore Drupal.Functions.DiscouragedFunctions.Discouraged
    eval($code);

    // phpcs:disable Drupal.Commenting.FunctionComment.Missing
    $kernel = new class {

      public function getCachedContainerDefinition(): array {
        $definitions['foo'] = ['class' => '\Foo'];
        return ['services' => \array_map('serialize', $definitions)];
      }

    };

    $entity_type_manager = new class {

      public function getDefinitions(): array {
        $definition = new class {

          public function getClass(): string {
            return '\EntityTypeExample';
          }

          public function getStorageClass(): string {
            // Define it without leading slash to test if it'll be normalized.
            return 'StorageExample';
          }

          public function getAccessControlClass(): string {
            return '\AccessControlExample';
          }

          public function hasViewBuilderClass(): bool {
            return TRUE;
          }

          public function getViewBuilderClass(): string {
            return '\Foo\BarViewBuilder';
          }

          public function hasListBuilderClass(): bool {
            return TRUE;
          }

          public function getListBuilderClass(): string {
            return '\Bar\FooListBuilder';
          }

        };
        $definitions['example'] = $definition;
        return $definitions;
      }

    };
    // phpcs:enable

    $container = $this->prophesize('\Symfony\Component\DependencyInjection\ContainerInterface');
    $container->get('kernel')->willReturn($kernel);
    $container->get('entity_type.manager')->willReturn($entity_type_manager);
    $this->generator = new PhpStormMetadata();
    $this->generator->setDrupalContext(new DrupalContext($container->reveal(), ''));
  }

  /**
   * Test callback.
   */
  public function testGenerator(): void {

    $tester = new GeneratorTester($this->generator);
    $tester->setDirectory($this->directory);
    $tester->execute();

    self::assertFileEquals($this->directory . '/.phpstorm.meta.php', __DIR__ . '/_phpstorm_meta.php');
    $expected_display = <<< 'TEXT'

     Welcome to phpstorm-metadata generator!
    –––––––––––––––––––––––––––––––––––––––––

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • .phpstorm.meta.php


    TEXT;
    self::assertSame($expected_display, $tester->getDisplay());
  }

}

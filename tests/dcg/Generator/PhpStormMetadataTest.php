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

      public function getCachedContainerDefinition() {
        $definitions['foo'] = ['class' => '\Foo'];
        return ['services' => \array_map('serialize', $definitions)];
      }

    };

    $entity_type_manager = new class {

      public function getDefinitions() {
        $definition = new class {

          public function getClass() {
            return '\EntityTypeExample';
          }

          public function getStorageClass() {
            // Define it without leading slash to test if it'll be normalized.
            return 'StorageExample';
          }

          public function getAccessControlClass() {
            return '\AccessControlExample';
          }

          public function hasViewBuilderClass() {
            return TRUE;
          }

          public function getViewBuilderClass() {
            return '\Foo\BarViewBuilder';
          }

          public function hasListBuilderClass() {
            return TRUE;
          }

          public function getListBuilderClass() {
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

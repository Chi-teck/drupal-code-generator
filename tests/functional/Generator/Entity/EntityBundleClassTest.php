<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Entity;

use DrupalCodeGenerator\Command\Entity\EntityBundleClass;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests entity:bundle-class generator.
 */
final class EntityBundleClassTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_entity_bundle_class';

  /**
   * Test callback.
   */
  public function testSingleBundleWithoutBaseClass(): void {

    // @todo Remove this once we drop support form Drupal 10.0.
    if (\str_starts_with(\getenv('DCG_DRUPAL_VERSION') ?: '', '10.0')) {
      self::markTestSkipped();
    }

    $input = [
      'foo',
      'Foo',
      'Content',
      'Article',
      'ArticleBundle',
      'No',
    ];
    $this->execute(EntityBundleClass::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to bundle-class generator!
    ––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Entity type:
      [ 1] Content block
      [ 2] Comment
      [ 3] Contact message
      [ 4] File
      [ 5] Custom menu link
      [ 6] Content
      [ 7] URL alias
      [ 8] Shortcut link
      [ 9] Taxonomy term
      [10] User
     ➤ 

     Bundles, comma separated:
      [1] Article
      [2] Basic page
     ➤ 

     Class for "Article" bundle [Article]:
     ➤ 

     Use a base class? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.info.yml
     • foo.module
     • src/Entity/Node/ArticleBundle.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_n_base_class';
    $this->assertGeneratedFile('foo.module');
    $this->assertGeneratedFile('src/Entity/Node/ArticleBundle.php');
  }

  /**
   * Test callback.
   */
  public function testAllBundlesWithBaseClass(): void {

    // @todo Remove this once we drop support form Drupal 10.0.
    if (\str_starts_with(\getenv('DCG_DRUPAL_VERSION') ?: '', '10.0')) {
      self::markTestSkipped();
    }

    $input = [
      'foo',
      'Foo',
      'Content',
      '1, 2',
      'Article',
      'Page',
      'Yes',
    ];
    $this->execute(EntityBundleClass::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to bundle-class generator!
    ––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Entity type:
      [ 1] Content block
      [ 2] Comment
      [ 3] Contact message
      [ 4] File
      [ 5] Custom menu link
      [ 6] Content
      [ 7] URL alias
      [ 8] Shortcut link
      [ 9] Taxonomy term
      [10] User
     ➤ 

     Bundles, comma separated:
      [1] Article
      [2] Basic page
     ➤ 

     Class for "Article" bundle [Article]:
     ➤ 

     Class for "Basic page" bundle [Page]:
     ➤ 

     Use a base class? [No]:
     ➤ 

     Base class [NodeBase]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.info.yml
     • foo.module
     • src/Entity/Node/Article.php
     • src/Entity/Node/NodeBase.php
     • src/Entity/Node/Page.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_w_base_class';
    $this->assertGeneratedFile('foo.module');
    $this->assertGeneratedFile('src/Entity/Node/NodeBase.php');
    $this->assertGeneratedFile('src/Entity/Node/Article.php');
    $this->assertGeneratedFile('src/Entity/Node/Page.php');
  }

}

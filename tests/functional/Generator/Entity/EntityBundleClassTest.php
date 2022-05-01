<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Entity;

use DrupalCodeGenerator\Command\Entity\EntityBundleClass;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Test for entity:bundle-class command.
 */
final class EntityBundleClassTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__;

  public function testSingleBundleWithoutBaseClass(): void {

    $input = [
      'foo',
      'Content',
      'Article',
      'ArticleBundle',
      'No',
    ];
    $this->execute(new EntityBundleClass(), $input);

    $expected_display = <<< 'TXT'

     Welcome to bundle-class generator!
    ––––––––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Entity type:
      [ 1] Custom block
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
      [1] All
      [2] Article
      [3] Basic page
     ➤ 

     Class for "Article" bundle [ArticleBundle]:
     ➤ 

     Use a base class? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.module
     • src/Entity/Bundle/ArticleBundle.php


    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_entity_bundle_class_without_base_class';
    $this->assertGeneratedFile('foo.module', 'foo.module');
    $this->assertGeneratedFile('src/Entity/Bundle/ArticleBundle.php', 'src/Entity/Bundle/ArticleBundle.php');
  }

  public function testAllBundlesWithBaseClass(): void {

    $input = [
      'foo',
      'Content',
      'All',
      'ArticleBundle',
      'PageBundle',
      'yes',
    ];
    $this->execute(new EntityBundleClass(), $input);

    $expected_display = <<< 'TXT'

     Welcome to bundle-class generator!
    ––––––––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Entity type:
      [ 1] Custom block
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
      [1] All
      [2] Article
      [3] Basic page
     ➤ 

     Class for "Article" bundle [ArticleBundle]:
     ➤ 

     Class for "Basic page" bundle [PageBundle]:
     ➤ 

     Use a base class? [No]:
     ➤ 

     Base class [NodeBundle]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.module
     • src/Entity/Bundle/ArticleBundle.php
     • src/Entity/Bundle/NodeBundle.php
     • src/Entity/Bundle/PageBundle.php


    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_entity_bundle_class_all_bundles_with_base_class';
    $this->assertGeneratedFile('foo.module', 'foo.module');
    $this->assertGeneratedFile('src/Entity/Bundle/ArticleBundle.php', 'src/Entity/Bundle/ArticleBundle.php');
    $this->assertGeneratedFile('src/Entity/Bundle/PageBundle.php', 'src/Entity/Bundle/PageBundle.php');
  }

}

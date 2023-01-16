<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Entity;

use DrupalCodeGenerator\Command\Entity\ContentEntity;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests content-entity generator.
 */
final class ContentEntityTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_content_entity';

  /**
   * Test callback.
   */
  public function testFull(): void {

    $input = [
      'foo',
      'Foo',
      'Example',
      'foo_example',
      '/example',
      'Yes',
      'Yes',
      'Yes',
      'Yes',
      'Yes',
      'Yes',
      'Yes',
      'Yes',
      'Yes',
      'Yes',
      'Yes',
      'Yes',
      'Yes',
      'Yes  ',
    ];
    $this->execute(ContentEntity::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to content-entity generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Entity type label [Foo]:
     ➤ 

     Entity type ID [example]:
     ➤ 

     Entity base path [/foo-example]:
     ➤ 

     Make the entity type fieldable? [Yes]:
     ➤ 

     Make the entity type revisionable? [No]:
     ➤ 

     Make the entity type translatable? [No]:
     ➤ 

     The entity type has bundle? [No]:
     ➤ 

     Create canonical page? [Yes]:
     ➤ 

     Create entity template? [Yes]:
     ➤ 

     Create CRUD permissions? [No]:
     ➤ 

     Add "label" base field? [Yes]:
     ➤ 

     Add "status" base field? [Yes]:
     ➤ 

     Add "created" base field? [Yes]:
     ➤ 

     Add "changed" base field? [Yes]:
     ➤ 

     Add "author" base field? [Yes]:
     ➤ 

     Add "description" base field? [Yes]:
     ➤ 

     Create REST configuration for the entity? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.links.action.yml
     • foo.links.contextual.yml
     • foo.links.menu.yml
     • foo.links.task.yml
     • foo.module
     • foo.permissions.yml
     • config/optional/rest.resource.entity.foo_example.yml
     • config/schema/foo.entity_type.schema.yml
     • src/FooExampleAccessControlHandler.php
     • src/FooExampleInterface.php
     • src/FooExampleListBuilder.php
     • src/FooExampleTypeListBuilder.php
     • src/Entity/FooExample.php
     • src/Entity/FooExampleType.php
     • src/Form/FooExampleForm.php
     • src/Form/FooExampleTypeForm.php
     • templates/foo-example.html.twig

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_yes';
    $this->assertGeneratedFile('foo.links.action.yml');
    $this->assertGeneratedFile('foo.links.contextual.yml');
    $this->assertGeneratedFile('foo.links.menu.yml');
    $this->assertGeneratedFile('foo.links.task.yml');
    $this->assertGeneratedFile('foo.module');
    $this->assertGeneratedFile('foo.permissions.yml');
    $this->assertGeneratedFile('config/optional/rest.resource.entity.foo_example.yml');
    $this->assertGeneratedFile('config/schema/foo.entity_type.schema.yml');
    $this->assertGeneratedFile('src/FooExampleAccessControlHandler.php');
    $this->assertGeneratedFile('src/FooExampleInterface.php');
    $this->assertGeneratedFile('src/FooExampleListBuilder.php');
    $this->assertGeneratedFile('src/FooExampleTypeListBuilder.php');
    $this->assertGeneratedFile('src/Entity/FooExample.php');
    $this->assertGeneratedFile('src/Entity/FooExampleType.php');
    $this->assertGeneratedFile('src/Form/FooExampleForm.php');
    $this->assertGeneratedFile('src/Form/FooExampleTypeForm.php');
    $this->assertGeneratedFile('templates/foo-example.html.twig');
  }

  /**
   * Test callback.
   */
  public function testLight(): void {

    $input = [
      'foo',
      'Foo',
      'Example',
      'foo_example',
      '/example',
      'No',
      'No',
      'No',
      'No',
      'No',
      'No',
      'No',
      'No',
      'No',
      'No',
      'No',
      'No',
      'No',
      'No  ',
    ];
    $this->execute(ContentEntity::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to content-entity generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Entity type label [Foo]:
     ➤ 

     Entity type ID [example]:
     ➤ 

     Entity base path [/foo-example]:
     ➤ 

     Make the entity type fieldable? [Yes]:
     ➤ 

     Make the entity type revisionable? [No]:
     ➤ 

     Make the entity type translatable? [No]:
     ➤ 

     The entity type has bundle? [No]:
     ➤ 

     Create canonical page? [Yes]:
     ➤ 

     Create CRUD permissions? [No]:
     ➤ 

     Add "label" base field? [Yes]:
     ➤ 

     Add "status" base field? [Yes]:
     ➤ 

     Add "created" base field? [Yes]:
     ➤ 

     Add "changed" base field? [Yes]:
     ➤ 

     Add "author" base field? [Yes]:
     ➤ 

     Add "description" base field? [Yes]:
     ➤ 

     Create REST configuration for the entity? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.links.action.yml
     • foo.links.menu.yml
     • foo.links.task.yml
     • foo.permissions.yml
     • src/FooExampleInterface.php
     • src/FooExampleListBuilder.php
     • src/Entity/FooExample.php
     • src/Form/FooExampleForm.php
     • src/Routing/FooExampleHtmlRouteProvider.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_no';
    $this->assertGeneratedFile('foo.links.action.yml');
    $this->assertGeneratedFile('foo.links.menu.yml');
    $this->assertGeneratedFile('foo.links.task.yml');
    $this->assertGeneratedFile('foo.permissions.yml');
    $this->assertGeneratedFile('src/FooExampleInterface.php');
    $this->assertGeneratedFile('src/FooExampleListBuilder.php');
    $this->assertGeneratedFile('src/Entity/FooExample.php');
    $this->assertGeneratedFile('src/Form/FooExampleForm.php');
    $this->assertGeneratedFile('src/Routing/FooExampleHtmlRouteProvider.php');
  }

}

<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\Field;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests field generator.
 */
final class FieldTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_field';

  public function testGenerator(): void {

    $input = [
      // General questions.
      'example',
      'Foo',
      'example_foo',
      '20',
      // Subfield questions.
      'Value 1', 'value_1', 'Boolean', 'No',
      'Value 2', 'value_2', 'Boolean', 'Yes',
      'Value 3', 'value_3', 'Text', 'No', 'No',
      'Value 4', 'value_4', 'Text', 'No', 'No',
      'Value 5', 'value_5', 'Text (long)', 'No',
      'Value 6', 'value_6', 'Text (long)', 'Yes',
      'Value 7', 'value_7', 'Integer', 'No', 'No',
      'Value 8', 'value_8', 'Integer', 'Yes', 'No',
      'Value 9', 'value_9', 'Float', 'No', 'No',
      'Value 10', 'value_10', 'Float', 'Yes', 'No',
      'Value 11', 'value_11', 'Numeric', 'No', 'Yes',
      'Value 12', 'value_12', 'Numeric', 'Yes', 'No',
      'Value 13', 'value_13', 'Email', 'No', 'Yes',
      'Value 14', 'value_14', 'Email', 'Yes', 'Yes',
      'Value 15', 'value_15', 'Telephone', 'No', 'Yes',
      'Value 16', 'value_16', 'Telephone', 'Yes', 'Yes',
      'Value 17', 'value_17', 'Url', 'No', 'No',
      'Value 18', 'value_18', 'Url', 'Yes', 'Yes',
      'Value 19', 'value_19', 'Date', 'Date only', 'No', 'Yes',
      'Value 20', 'value_20', 'Date', 'Date only', 'Yes',
      // Field plugin questions.
      'Yes',
      'Yes',
      'Yes',
      'Yes',
      'Yes',
      'Yes',
      'Yes',
    ];
    $this->execute(Field::class, $input);

    $type_options = <<< 'TXT'
      [ 1] Boolean
      [ 2] Text
      [ 3] Text (long)
      [ 4] Integer
      [ 5] Float
      [ 6] Numeric
      [ 7] Email
      [ 8] Telephone
      [ 9] Url
      [10] Date
    TXT;

    $expected_display = <<< TXT

     Welcome to field generator!
    –––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Field label [Example]:
     ➤ 

     Field ID [example_foo]:
     ➤ 

     How many sub-fields would you like to create? [3]:
     ➤ 
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Label for sub-field #1 [Value 1]:
     ➤ 

     Machine name for sub-field #1 [value_1]:
     ➤ 

     Type of sub-field #1 [Text]:
    $type_options
     ➤ 

     Make sub-field #1 required? [No]:
     ➤ 
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Label for sub-field #2 [Value 2]:
     ➤ 

     Machine name for sub-field #2 [value_2]:
     ➤ 

     Type of sub-field #2 [Text]:
    $type_options
     ➤ 

     Make sub-field #2 required? [No]:
     ➤ 
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Label for sub-field #3 [Value 3]:
     ➤ 

     Machine name for sub-field #3 [value_3]:
     ➤ 

     Type of sub-field #3 [Text]:
    $type_options
     ➤ 

     Limit allowed values for sub-field #3? [No]:
     ➤ 

     Make sub-field #3 required? [No]:
     ➤ 
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Label for sub-field #4 [Value 4]:
     ➤ 

     Machine name for sub-field #4 [value_4]:
     ➤ 

     Type of sub-field #4 [Text]:
    $type_options
     ➤ 

     Limit allowed values for sub-field #4? [No]:
     ➤ 

     Make sub-field #4 required? [No]:
     ➤ 
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Label for sub-field #5 [Value 5]:
     ➤ 

     Machine name for sub-field #5 [value_5]:
     ➤ 

     Type of sub-field #5 [Text]:
    $type_options
     ➤ 

     Make sub-field #5 required? [No]:
     ➤ 
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Label for sub-field #6 [Value 6]:
     ➤ 

     Machine name for sub-field #6 [value_6]:
     ➤ 

     Type of sub-field #6 [Text]:
    $type_options
     ➤ 

     Make sub-field #6 required? [No]:
     ➤ 
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Label for sub-field #7 [Value 7]:
     ➤ 

     Machine name for sub-field #7 [value_7]:
     ➤ 

     Type of sub-field #7 [Text]:
    $type_options
     ➤ 

     Limit allowed values for sub-field #7? [No]:
     ➤ 

     Make sub-field #7 required? [No]:
     ➤ 
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Label for sub-field #8 [Value 8]:
     ➤ 

     Machine name for sub-field #8 [value_8]:
     ➤ 

     Type of sub-field #8 [Text]:
    $type_options
     ➤ 

     Limit allowed values for sub-field #8? [No]:
     ➤ 

     Make sub-field #8 required? [No]:
     ➤ 
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Label for sub-field #9 [Value 9]:
     ➤ 

     Machine name for sub-field #9 [value_9]:
     ➤ 

     Type of sub-field #9 [Text]:
    $type_options
     ➤ 

     Limit allowed values for sub-field #9? [No]:
     ➤ 

     Make sub-field #9 required? [No]:
     ➤ 
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Label for sub-field #10 [Value 10]:
     ➤ 

     Machine name for sub-field #10 [value_10]:
     ➤ 

     Type of sub-field #10 [Text]:
    $type_options
     ➤ 

     Limit allowed values for sub-field #10? [No]:
     ➤ 

     Make sub-field #10 required? [No]:
     ➤ 
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Label for sub-field #11 [Value 11]:
     ➤ 

     Machine name for sub-field #11 [value_11]:
     ➤ 

     Type of sub-field #11 [Text]:
    $type_options
     ➤ 

     Limit allowed values for sub-field #11? [No]:
     ➤ 

     Make sub-field #11 required? [No]:
     ➤ 
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Label for sub-field #12 [Value 12]:
     ➤ 

     Machine name for sub-field #12 [value_12]:
     ➤ 

     Type of sub-field #12 [Text]:
    $type_options
     ➤ 

     Limit allowed values for sub-field #12? [No]:
     ➤ 

     Make sub-field #12 required? [No]:
     ➤ 
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Label for sub-field #13 [Value 13]:
     ➤ 

     Machine name for sub-field #13 [value_13]:
     ➤ 

     Type of sub-field #13 [Text]:
    $type_options
     ➤ 

     Limit allowed values for sub-field #13? [No]:
     ➤ 

     Make sub-field #13 required? [No]:
     ➤ 
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Label for sub-field #14 [Value 14]:
     ➤ 

     Machine name for sub-field #14 [value_14]:
     ➤ 

     Type of sub-field #14 [Text]:
    $type_options
     ➤ 

     Limit allowed values for sub-field #14? [No]:
     ➤ 

     Make sub-field #14 required? [No]:
     ➤ 
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Label for sub-field #15 [Value 15]:
     ➤ 

     Machine name for sub-field #15 [value_15]:
     ➤ 

     Type of sub-field #15 [Text]:
    $type_options
     ➤ 

     Limit allowed values for sub-field #15? [No]:
     ➤ 

     Make sub-field #15 required? [No]:
     ➤ 
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Label for sub-field #16 [Value 16]:
     ➤ 

     Machine name for sub-field #16 [value_16]:
     ➤ 

     Type of sub-field #16 [Text]:
    $type_options
     ➤ 

     Limit allowed values for sub-field #16? [No]:
     ➤ 

     Make sub-field #16 required? [No]:
     ➤ 
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Label for sub-field #17 [Value 17]:
     ➤ 

     Machine name for sub-field #17 [value_17]:
     ➤ 

     Type of sub-field #17 [Text]:
    $type_options
     ➤ 

     Limit allowed values for sub-field #17? [No]:
     ➤ 

     Make sub-field #17 required? [No]:
     ➤ 
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Label for sub-field #18 [Value 18]:
     ➤ 

     Machine name for sub-field #18 [value_18]:
     ➤ 

     Type of sub-field #18 [Text]:
    $type_options
     ➤ 

     Limit allowed values for sub-field #18? [No]:
     ➤ 

     Make sub-field #18 required? [No]:
     ➤ 
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Label for sub-field #19 [Value 19]:
     ➤ 

     Machine name for sub-field #19 [value_19]:
     ➤ 

     Type of sub-field #19 [Text]:
    $type_options
     ➤ 

     Date type for sub-field #19 [Date only]:
      [1] Date only
      [2] Date and time
     ➤ 

     Limit allowed values for sub-field #19? [No]:
     ➤ 

     Make sub-field #19 required? [No]:
     ➤ 
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Label for sub-field #20 [Value 20]:
     ➤ 

     Machine name for sub-field #20 [value_20]:
     ➤ 

     Type of sub-field #20 [Text]:
    $type_options
     ➤ 

     Date type for sub-field #20 [Date only]:
      [1] Date only
      [2] Date and time
     ➤ 

     Limit allowed values for sub-field #20? [No]:
     ➤ 

     Make sub-field #20 required? [No]:
     ➤ 
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Would you like to create field storage settings form? [No]:
     ➤ 

     Would you like to create field instance settings form? [No]:
     ➤ 

     Would you like to create field widget settings form? [No]:
     ➤ 

     Would you like to create field formatter settings form? [No]:
     ➤ 

     Would you like to create table formatter? [No]:
     ➤ 

     Would you like to create key-value formatter? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.libraries.yml
     • config/schema/example.schema.yml
     • css/example-foo-widget.css
     • src/Plugin/Field/FieldFormatter/FooDefaultFormatter.php
     • src/Plugin/Field/FieldFormatter/FooKeyValueFormatter.php
     • src/Plugin/Field/FieldFormatter/FooTableFormatter.php
     • src/Plugin/Field/FieldType/FooItem.php
     • src/Plugin/Field/FieldWidget/FooWidget.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.libraries.yml');
    $this->assertGeneratedFile('config/schema/example.schema.yml');
    $this->assertGeneratedFile('css/example-foo-widget.css');
    $this->assertGeneratedFile('src/Plugin/Field/FieldFormatter/FooDefaultFormatter.php');
    $this->assertGeneratedFile('src/Plugin/Field/FieldFormatter/FooKeyValueFormatter.php');
    $this->assertGeneratedFile('src/Plugin/Field/FieldFormatter/FooTableFormatter.php');
    $this->assertGeneratedFile('src/Plugin/Field/FieldType/FooItem.php');
    $this->assertGeneratedFile('src/Plugin/Field/FieldWidget/FooWidget.php');
  }

}

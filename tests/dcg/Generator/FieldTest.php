<?php

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for field command.
 */
final class FieldTest extends BaseGeneratorTest {

  protected $class = 'Field';

  protected $fixtures = [
    'example.libraries.yml' => '/_field/_libraries.yml',
    'css/example-foo-widget.css' => '/_field/_widget.css',
    'config/schema/example.schema.yml' => '/_field/_schema.yml',
    'src/Plugin/Field/FieldFormatter/FooDefaultFormatter.php' => '/_field/_default_formatter.php',
    'src/Plugin/Field/FieldFormatter/FooKeyValueFormatter.php' => '/_field/_key_value_formatter.php',
    'src/Plugin/Field/FieldFormatter/FooTableFormatter.php' => '/_field/_table_formatter.php',
    'src/Plugin/Field/FieldType/FooItem.php' => '/_field/_type.php',
    'src/Plugin/Field/FieldWidget/FooWidget.php' => '/_field/_widget.php',
  ];

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {

    $type_options = [
      '  [ 1] Boolean',
      '  [ 2] Text',
      '  [ 3] Text (long)',
      '  [ 4] Integer',
      '  [ 5] Float',
      '  [ 6] Numeric',
      '  [ 7] Email',
      '  [ 8] Telephone',
      '  [ 9] Url',
      '  [10] Date',
    ];
    $type_options = "\n" . implode("\n", $type_options);

    $date_options = [
      '  [1] Date only',
      '  [2] Date and time',
    ];
    $date_options = "\n" . implode("\n", $date_options);

    $this->interaction = [
      // General questions.
      'Module name [%default_name%]:' => 'Example',
      'Module machine name [example]:' => 'example',
      'Field label [Example]:' => 'Foo',
      'Field ID [example_foo]:' => 'example_foo',
      'How many sub-fields would you like to create? [3]:' => 20,
      // Subfield #1.
      'Label for sub-field #1 [Value 1]:' => 'Value 1',
      'Machine name for sub-field #1 [value_1]:' => 'value_1',
      'Type of sub-field #1 [Text]:' . $type_options => 'Boolean',
      'Make sub-field #1 required? [No]:' => 'No',
      // Subfield #2.
      'Label for sub-field #2 [Value 2]:' => 'Value 2',
      'Machine name for sub-field #2 [value_2]:' => 'value_2',
      'Type of sub-field #2 [Text]:' . $type_options => 'Boolean',
      'Make sub-field #2 required? [No]:' => 'Yes',
      // Subfield #3.
      'Label for sub-field #3 [Value 3]:' => 'Value 3',
      'Machine name for sub-field #3 [value_3]:' => 'value_3',
      'Type of sub-field #3 [Text]:' . $type_options => 'Text',
      'Limit allowed values for sub-field #3? [No]:' => 'No',
      'Make sub-field #3 required? [No]:' => 'No',
      // Subfield #4.
      'Label for sub-field #4 [Value 4]:' => 'Value 4',
      'Machine name for sub-field #4 [value_4]:' => 'value_4',
      'Type of sub-field #4 [Text]:' . $type_options => 'Text',
      'Limit allowed values for sub-field #4? [No]:' => 'No',
      'Make sub-field #4 required? [No]:' => 'No',
      // Subfield #5.
      'Label for sub-field #5 [Value 5]:' => 'Value 5',
      'Machine name for sub-field #5 [value_5]:' => 'value_5',
      'Type of sub-field #5 [Text]:' . $type_options => 'Text (long)',
      'Make sub-field #5 required? [No]:' => 'No',
      // Subfield #6.
      'Label for sub-field #6 [Value 6]:' => 'Value 6',
      'Machine name for sub-field #6 [value_6]:' => 'value_6',
      'Type of sub-field #6 [Text]:' . $type_options => 'Text (long)',
      'Make sub-field #6 required? [No]:' => 'Yes',
      // Subfield #7.
      'Label for sub-field #7 [Value 7]:' => 'Value 7',
      'Machine name for sub-field #7 [value_7]:' => 'value_7',
      'Type of sub-field #7 [Text]:' . $type_options => 'Integer',
      'Limit allowed values for sub-field #7? [No]:' => 'No',
      'Make sub-field #7 required? [No]:' => 'No',
      // Subfield #8.
      'Label for sub-field #8 [Value 8]:' => 'Value 8',
      'Machine name for sub-field #8 [value_8]:' => 'value_8',
      'Type of sub-field #8 [Text]:' . $type_options => 'Integer',
      'Limit allowed values for sub-field #8? [No]:' => 'Yes',
      'Make sub-field #8 required? [No]:' => 'No',
      // Subfield #9.
      'Label for sub-field #9 [Value 9]:' => 'Value 9',
      'Machine name for sub-field #9 [value_9]:' => 'value_9',
      'Type of sub-field #9 [Text]:' . $type_options => 'Float',
      'Limit allowed values for sub-field #9? [No]:' => 'No',
      'Make sub-field #9 required? [No]:' => 'No',
      // Subfield #10.
      'Label for sub-field #10 [Value 10]:' => 'Value 10',
      'Machine name for sub-field #10 [value_10]:' => 'value_10',
      'Type of sub-field #10 [Text]:' . $type_options => 'Float',
      'Limit allowed values for sub-field #10? [No]:' => 'Yes',
      'Make sub-field #10 required? [No]:' => 'No',
      // Subfield #11.
      'Label for sub-field #11 [Value 11]:' => 'Value 11',
      'Machine name for sub-field #11 [value_11]:' => 'value_11',
      'Type of sub-field #11 [Text]:' . $type_options => 'Numeric',
      'Limit allowed values for sub-field #11? [No]:' => 'No',
      'Make sub-field #11 required? [No]:' => 'Yes',
      // Subfield #12.
      'Label for sub-field #12 [Value 12]:' => 'Value 12',
      'Machine name for sub-field #12 [value_12]:' => 'value_12',
      'Type of sub-field #12 [Text]:' . $type_options => 'Numeric',
      'Limit allowed values for sub-field #12? [No]:' => 'Yes',
      'Make sub-field #12 required? [No]:' => 'No',
      // Subfield #13.
      'Label for sub-field #13 [Value 13]:' => 'Value 13',
      'Machine name for sub-field #13 [value_13]:' => 'value_13',
      'Type of sub-field #13 [Text]:' . $type_options => 'Email',
      'Limit allowed values for sub-field #13? [No]:' => 'No',
      'Make sub-field #13 required? [No]:' => 'Yes',
      // Subfield #14.
      'Label for sub-field #14 [Value 14]:' => 'Value 14',
      'Machine name for sub-field #14 [value_14]:' => 'value_14',
      'Type of sub-field #14 [Text]:' . $type_options => 'Email',
      'Limit allowed values for sub-field #14? [No]:' => 'Yes',
      'Make sub-field #14 required? [No]:' => 'Yes',
      // Subfield #15.
      'Label for sub-field #15 [Value 15]:' => 'Value 15',
      'Machine name for sub-field #15 [value_15]:' => 'value_15',
      'Type of sub-field #15 [Text]:' . $type_options => 'Telephone',
      'Limit allowed values for sub-field #15? [No]:' => 'No',
      'Make sub-field #15 required? [No]:' => 'Yes',
      // Subfield #16.
      'Label for sub-field #16 [Value 16]:' => 'Value 16',
      'Machine name for sub-field #16 [value_16]:' => 'value_16',
      'Type of sub-field #16 [Text]:' . $type_options => 'Telephone',
      'Limit allowed values for sub-field #16? [No]:' => 'Yes',
      'Make sub-field #16 required? [No]:' => 'Yes',
      // Subfield #17.
      'Label for sub-field #17 [Value 17]:' => 'Value 17',
      'Machine name for sub-field #17 [value_17]:' => 'value_17',
      'Type of sub-field #17 [Text]:' . $type_options => 'Url',
      'Limit allowed values for sub-field #17? [No]:' => 'No',
      'Make sub-field #17 required? [No]:' => 'No',
      // Subfield #18.
      'Label for sub-field #18 [Value 18]:' => 'Value 18',
      'Machine name for sub-field #18 [value_18]:' => 'value_18',
      'Type of sub-field #18 [Text]:' . $type_options => 'Url',
      'Limit allowed values for sub-field #18? [No]:' => 'Yes',
      'Make sub-field #18 required? [No]:' => 'Yes',
      // Subfield #19.
      'Label for sub-field #19 [Value 19]:' => 'Value 19',
      'Machine name for sub-field #19 [value_19]:' => 'value_19',
      'Type of sub-field #19 [Text]:' . $type_options => 'Date',
      'Date type for sub-field #19 [Date only]:' . $date_options => 'Date only',
      'Limit allowed values for sub-field #19? [No]:' => 'No',
      'Make sub-field #19 required? [No]:' => 'Yes',
      // Subfield #20.
      'Label for sub-field #20 [Value 20]:' => 'Value 20',
      'Machine name for sub-field #20 [value_20]:' => 'value_20',
      'Type of sub-field #20 [Text]:' . $type_options => 'Date',
      'Date type for sub-field #20 [Date only]:' . $date_options => 'Date only',
      'Limit allowed values for sub-field #20? [No]:' => 'Yes',
      'Make sub-field #20 required? [No]:' => 'Yes',
      // Settings form questions.
      'Would you like to create field storage settings form? [No]:' => 'Yes',
      'Would you like to create field instance settings form? [No]:' => 'Yes',
      'Would you like to create field widget settings form? [No]:' => 'Yes',
      'Would you like to create field formatter settings form? [No]:' => 'Yes',
      'Would you like to create table formatter? [No]:' => 'Yes',
      'Would you like to create key-value formatter? [No]:' => 'Yes',
    ];

    parent::setUp();
  }

  /**
   * {@inheritdoc}
   */
  protected function processExpectedDisplay(string $display): string {
    $display = self::insertRule($display, 'Label for sub-field');
    $display = self::insertRule($display, 'Would you like to create field storage settings form');
    return $display;
  }

  /**
   * Inserts header line into display.
   */
  private static function insertRule(string $display, string $text): string {
    $line = "––––––––––––––––––––––––––––––––––––––––––––––––––\n\n";
    return preg_replace("/\n $text/", $line . " $text", $display);
  }

}

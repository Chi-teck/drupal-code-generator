<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\Template;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests template generator.
 */
final class TemplateTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_template';

  /**
   * Test callback.
   */
  public function testGenerator(): void {

    $user_input = ['example', 'Example', 'section', 'Yes', 'Yes'];
    $this->execute(Template::class, $user_input);

    $expected_display = <<< 'TXT'

     Welcome to template generator!
    ––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Example]:
     ➤ 

     Template name:
     ➤ 

     Create theme hook? [Yes]:
     ➤ 

     Create preprocess hook? [Yes]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml
     • example.module
     • templates/section.html.twig

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.module');
    $this->assertGeneratedFile('templates/section.html.twig');
  }

  /**
   * Test callback.
   *
   * @dataProvider templateNameValidatorProvider()
   */
  public function testTemplateNameValidator(mixed $value, bool $exception): void {
    if ($exception) {
      self::expectExceptionObject(new \UnexpectedValueException('The value is not correct template name'));
    }
    $result = Template::validateTemplateName($value);
    self::assertSame($value, $result);

  }

  /**
   * Data provider callback for testTemplateNameValidator().
   */
  public function templateNameValidatorProvider(): array {
    return [
      ['aaa', FALSE],
      ['aaa.bbb', FALSE],
      ['aaa.bbb.html', FALSE],
      ['aaa.bbb.html.twig', FALSE],
      ['aaa-bbb.html.twig', FALSE],
      ['aaa_bbb.html.twig', TRUE],
      ['123.aaa-bbb.456', FALSE],
      ['aaa_bbb', TRUE],
      ['_aaa', TRUE],
      ['Aaa', TRUE],
      ['aaa-', TRUE],
      ['aaa bbb', TRUE],
    ];
  }

}

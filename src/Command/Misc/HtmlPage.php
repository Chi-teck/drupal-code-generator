<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Misc;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\Generator;

/**
 * Implements misc:html-page command.
 */
final class HtmlPage extends Generator {

  protected string $name = 'misc:html-page';
  protected string $description = 'Generates a simple html page';
  protected string $alias = 'html-page';
  protected string $label = 'HTML page';
  protected string $templatePath = Application::TEMPLATE_PATH . '/misc/html-page';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $vars['file_name'] = $this->ask('File name', 'index.html');
    $this->addFile('{file_name}', 'index');
    $this->addFile('css/main.css')
      ->content("body{\n  background-color: #EEE;\n}\n");
    $this->addFile('js/main.js')
      ->content("console.log('It works!');\n");
  }

}
